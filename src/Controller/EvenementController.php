<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Ticket;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EvenementController extends AbstractController
{
    #[Route(name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/dbfrsevents', name: 'dbfrsevents', methods: ['GET'])]
    public function indexfrs(EvenementRepository $evenementRepository): Response
    {
        return $this->render('dbFournisseurEvents.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('dbfrsevents', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_evenement_show', methods: ['GET', 'POST'])]
    public function show(Request $request, EvenementRepository $evenementRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        $evenement = $evenementRepository->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException('The event does not exist');
        }

        if ($request->isMethod('POST')) {
            $user = 1;     //$this->getUser();
            if (!$user) {
                throw $this->createAccessDeniedException('You must be logged in to participate in an event');
            }

            if ($evenement->getNombreDePlaces() <= 0) {
                $this->addFlash('error', 'No more places available for this event');
                return $this->redirectToRoute('app_evenement_show', ['id' => $id]);
            }

            $evenement->setNombreDePlaces($evenement->getNombreDePlaces() - 1);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_show', ['id' => $evenement->getId()]);
        }

        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EvenementRepository $evenementRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        $evenement = $evenementRepository->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException('The event does not exist');
        }

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('dbfrsevents', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id<\d+>}/delete', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dbfrsevents', [], Response::HTTP_SEE_OTHER);
    }
}
