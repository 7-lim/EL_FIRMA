<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ticket')]
final class TicketController extends AbstractController
{
    #[Route(name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        // Add eager loading to prevent N+1 queries
        $tickets = $ticketRepository->createQueryBuilder('t')
            ->leftJoin('t.evenement', 'e')
            ->addSelect('e')
            ->getQuery()
            ->getResult();
    
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement = $ticket->getEvenement();
            $prix = $ticket->getPrix();
            $nombreDePlaces = $evenement->getNombreDePlaces();
    
            // Verify event exists
            if (!$evenement) {
                $this->addFlash('error', 'Événement invalide');
                return $this->redirectToRoute('app_ticket_new');
            }
    
            // Validate places
            if ($nombreDePlaces <= 0) {
                $this->addFlash('error', 'Nombre de places insuffisant');
                return $this->redirectToRoute('app_ticket_new');
            }
    
            // Create tickets
            for ($i = 0; $i < $nombreDePlaces; $i++) {
                $newTicket = new Ticket();
                $newTicket->setPrix($prix);
                $newTicket->setEvenement($evenement);
                $entityManager->persist($newTicket);
            }
    
            try {
                $entityManager->flush();
                $this->addFlash('success', "$nombreDePlaces tickets créés avec succès!");
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la création: ' . $e->getMessage());
            }
    
            return $this->redirectToRoute('app_ticket_index');
        }
    
        // Handle form errors
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire');
        }
    
        return $this->render('ticket/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
