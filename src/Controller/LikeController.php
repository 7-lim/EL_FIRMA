<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Message;
use App\Entity\Like;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LikeRepository;

final class LikeController extends AbstractController
{
    #[Route('/like', name: 'app_like')]
    public function index(): Response
    {
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
        ]);
    }

    #[Route('/like/{id}', name: 'app_like', methods: ['POST'])]
    public function likeMessage(Message $message, EntityManagerInterface $em, LikeRepository $likeRepo): Response
    {
        $user = $this->getUser();
       
    
        $existingLike = $likeRepo->findOneBy([
            'emetteur' => $user,
            'message' => $message
        ]);
    
        if ($existingLike) {
            $em->remove($existingLike);
            $this->addFlash('success', 'Like retiré.');
        } else {
            $like = new Like();
            $like->setEmetteur($user);
            $like->setMessage($message);
            $em->persist($like);
            $this->addFlash('success', 'Message liké.');
        }
    
        $em->flush();
    
        return $this->redirectToRoute('add_message', ['id' => $message->getDiscussion()->getId()]);
    }
    

    #[Route('/message/{id}/likes', name: 'message_likes', methods: ['GET'])]
public function getLikesCount(Message $message, LikeRepository $likeRepo): Response
{
    $likeCount = $likeRepo->count(['message' => $message]);

    return $this->json(['likes' => $likeCount]);
}
}
