<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Discussion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\DiscussionType;
use App\Repository\DiscussionRepository;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscussionController extends AbstractController
{
  
    #[Route('/discussionsAdmin', name: 'app_discussion')]
    public function index(DiscussionRepository $discussionRepository): Response
    {
        $discussions = $discussionRepository->findAll();

        return $this->render('discussion/listDiscussionBack.html.twig', [
            'controller_name' => 'DiscussionController',
            'discussions' => $discussions,
        ]);
    }
    #[Route('/discussions', name: 'list_discussions', methods: ['GET'])]
    public function show(Request $request,DiscussionRepository $discussionRepository,ManagerRegistry $doctrine):Response{
        $discussions = $discussionRepository->findAll();

        
        return $this->render('discussion/index.html.twig', [
            'discussions' => $discussions,
        ]);
        

    }
    #[Route('/discussion/add', name: 'add_discussion', methods: ['GET', 'POST'])]
    public function new(Request $request,ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $discussion = new Discussion();
        $discussion->setCreateur(null);
        $form = $this->createForm(DiscussionType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($discussion);

            $em->flush();

            return $this->redirectToRoute('list_discussions');
        }

        return $this->renderForm('/discussion/new.html.twig', [
            'discussion' => $discussion,
            'form' => $form,
        ]);
    }
    #[Route('/discussion/edit/{id}', name: 'edit_discussion', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager,DiscussionRepository $discussionRepository): Response
    {
        $discussion = $discussionRepository->find($id);

        $form = $this->createForm(DiscussionType::class, $discussion);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();
    
            return $this->redirectToRoute('list_discussions', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('discussion/edit.html.twig', [
            'discussion' => $discussion,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/discussion/delete/{idDiscussion}', name: 'delete_discussion')]
    public function delete(int $idDiscussion, EntityManagerInterface $entityManager, DiscussionRepository $discussionRepository): Response
    {
        $discussion = $discussionRepository->find($idDiscussion);
    
        if (!$discussion) {
            throw $this->createNotFoundException('Discussion not found');
        }
    
        $entityManager->remove($discussion);
        $entityManager->flush();
    
        return $this->redirectToRoute('list_discussions', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/discussions/delete/{idDiscussion}', name: 'delete_discussion_back')]
    public function deleteBack(int $idDiscussion, EntityManagerInterface $entityManager, DiscussionRepository $discussionRepository): Response
    {
        $discussion = $discussionRepository->find($idDiscussion);
    
        if (!$discussion) {
            throw $this->createNotFoundException('Discussion not found');
        }
    
        $entityManager->remove($discussion);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_discussion');
    }



}