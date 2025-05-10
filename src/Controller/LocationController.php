<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Service\PdfService;
use App\Service\PdfContractGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LocationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;







#[Route('/location')]
class LocationController extends AbstractController
{
    private PdfService $pdfService;
    private PdfContractGenerator $pdfContractGenerator;

    public function __construct(PdfService $pdfService, PdfContractGenerator $pdfContractGenerator)
    {
        $this->pdfService = $pdfService;
        $this->pdfContractGenerator = $pdfContractGenerator;
    }



    #[Route('/', name: 'location_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $locations = $entityManager->getRepository(Location::class)->findAll();
        return $this->render('location/index.html.twig', [
            'locations' => $locations,
        ]);
    }

    #[Route('/new', name: 'location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($location);
            $entityManager->flush();

            $this->addFlash('success', 'Location ajoutée avec succès !');
            return $this->redirectToRoute('location_index');
        }

        return $this->render('location/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'location_show', methods: ['GET'])]
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    #[Route('/{id}/edit', name: 'location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Location modifiée avec succès !');
            return $this->redirectToRoute('location_index');
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form'     => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'location_delete', methods: ['POST'])]
    public function delete(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $location->getId(), $request->request->get('_token'))) {
            $entityManager->remove($location);
            $entityManager->flush();
            $this->addFlash('success', 'Location supprimée avec succès !');
        }

        return $this->redirectToRoute('location_index');
        
    }






    #[Route('/locations/search', name: 'search_locations', methods: ['GET'])]
    public function search(Request $request, LocationRepository $locationRepository): JsonResponse
    {
        $query = $request->query->get('q', '');
        $sort = $request->query->get('sort', 'prixLocation');
        $direction = $request->query->get('direction', 'ASC');

        $locations = $locationRepository->searchLocations($query, $sort, $direction);

        return $this->json($locations);
    }












    #[Route('/{id}/pdf', name: 'location_pdf', methods: ['GET'])]
    public function generateLocationPdf(Location $location): Response
    {
        // Rendu du template en HTML
        $html = $this->renderView('location/pdf.html.twig', [
            'location' => $location,
        ]);

        // Génération du PDF
        return $this->pdfService->generatePdf($html, 'location_' . $location->getId() . '.pdf');
    }

    #[Route('/contract/{id}', name: 'location_generate_contract', methods: ['GET'])]
    public function generateContract(int $id, EntityManagerInterface $em): Response
    {
        $location = $em->getRepository(Location::class)->find($id);
        if (!$location) {
            return $this->json(['error' => 'Location not found'], Response::HTTP_NOT_FOUND);
        }

        $pdfPath = $this->pdfContractGenerator->generateContract($location);
        return $this->file($pdfPath, 'contract.pdf');
    }
}
