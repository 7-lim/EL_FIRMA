<?php

namespace App\Controller;
use App\Entity\Discussion;
use App\Entity\Message;
use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\DiscussionRepository;
use App\Repository\MessageRepository;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailerService;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    // src/Controller/DiscussionController.php
    #[Route('/discussion/{id}', name: 'add_message', methods: ['GET', 'POST'])]
    public function show(
        MailerService $mailerService, 
        int $id, 
        DiscussionRepository $discussionRepository, 
        MessageRepository $messageRepository, 
        Request $request, 
        ManagerRegistry $doctrine
    ) {   
        $discussion = $discussionRepository->find($id);
        $colorCode = $discussion->getColorCode();
        $messages = $messageRepository->findMessagesByDiscussionOrderedByLikes($id);
    
        $em = $doctrine->getManager();
        $message = new Message();
        $message->setDiscussion($discussion);
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('image')->getData();
    
            if ($uploadedFile) {
                // Initialisation de Cloudinary
                $cloudinary = new \Cloudinary\Cloudinary($_ENV['CLOUDINARY_URL']);
    
                // Upload de l'image sur Cloudinary
                $uploadedResponse = $cloudinary->uploadApi()->upload($uploadedFile->getPathname(), [
                    'folder' => 'messages'
                ]);
    
                // Stocker l'URL de l'image dans l'entité Message
                $message->setImage($uploadedResponse['secure_url']);
            }
    
            $em->persist($message);
            $em->flush();
    
            // Envoi d'un email de notification
            //$this->getUser()
            //$recipientEmail=$this->getUser()->getEmail();
            $recipientEmail = "hamidonmejri@gmail.com";
            $mailerService->sendNewMessageNotification($recipientEmail, $message->getContenu());
    
            return $this->redirectToRoute('add_message', ['id' => $id]);
        }
    
        return $this->renderForm('message/_form.html.twig', [
            'id' => $id,
            'messages' => $messages,
            'message' => $message,
            'form' => $form,
            'colorCode' => $colorCode,
            'discussion' => $discussion,
        ]);
    }
    
#[Route('/message/delete/{id}/{idDiscussion}', name: 'delete_message')]
    public function delete(int $id, int $idDiscussion,  EntityManagerInterface $entityManager, MessageRepository $messageRepository): Response
    {
        $message = $messageRepository->find($id);
    
        if (!$message) {
            throw $this->createNotFoundException('Message not found');
        }
    
        $entityManager->remove($message);

        $entityManager->flush();
    
        return $this->redirectToRoute('add_message',  ['id' => $idDiscussion], Response::HTTP_SEE_OTHER);
    }
    #[Route('/message/update/{id}/{idDiscussion}', name: 'update_message')]

    public function updateMessage(Request $request,DiscussionRepository $discussionRepository, $id, int $idDiscussion,  EntityManagerInterface $entityManager, MessageRepository $messageRepository,ManagerRegistry $doctrine)
{
    $message = $messageRepository->find($id);
    $discussion = $discussionRepository->find($idDiscussion);
    $colorCode = $discussion->getColorCode();
    
    $messages = $messageRepository->findMessagesByDiscussion($id);
  

    
    $form = $this->createForm(MessageType::class, $message);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $uploadedFile = $form->get('image')->getData();
            
        if ($uploadedFile) {
            // Initialiser Cloudinary
            $cloudinary = new \Cloudinary\Cloudinary($_ENV['CLOUDINARY_URL']);
            
            // Télécharger l'image sur Cloudinary
            $uploadedResponse = $cloudinary->uploadApi()->upload($uploadedFile->getPathname(), [
                'folder' => 'messages'
            ]);
            
            // Enregistrer l'URL de l'image dans le message
            $message->setImage($uploadedResponse['secure_url']);
        }

        $entityManager->persist($message);
        $entityManager->flush();
        
        return $this->redirectToRoute('add_message',  ['id' => $idDiscussion], Response::HTTP_SEE_OTHER);
    }
    
    return $this->render('message/_form.html.twig', [
        'id'=>$idDiscussion,
        'messages' => $messages,
        'form' => $form->createView(),
        'message' => $message,
        'colorCode'=>$colorCode
    ]);
}


}