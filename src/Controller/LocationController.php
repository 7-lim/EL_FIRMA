<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Terrain;

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
    public function index(LocationRepository $locationRepository): Response
    {
        $locations = $locationRepository->findAll();
        return $this->render('location/index.html.twig', ['locations' => $locations]);
    }

    #[Route('/new', name: 'location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LocationRepository $locationRepository, EntityManagerInterface $entityManager): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 🛑 Prevent duplicate bookings
            if (!$locationRepository->isTerrainAvailable($location->getTerrain(), $location->getDateDebut(), $location->getDateFin())) {
                $this->addFlash('danger', 'Le terrain est déjà réservé pour ces dates.');
                return $this->render('location/new.html.twig', ['form' => $form->createView()]);
            }

            $entityManager->persist($location);
            $entityManager->flush();

            $this->addFlash('success', 'Location ajoutée avec succès !');
            return $this->redirectToRoute('location_index');
        }

        return $this->render('location/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'location_show', methods: ['GET'])]
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', ['location' => $location]);
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
            'form' => $form->createView(),
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
        // Validate and sanitize query parameters
        $minPrix = filter_var($request->query->get('minPrix', 0), FILTER_VALIDATE_FLOAT) ?: 0;
        $maxPrix = filter_var($request->query->get('maxPrix', 1000000), FILTER_VALIDATE_FLOAT) ?: 1000000;
        $sort = $request->query->get('sort', 'prixLocation');
        $direction = strtoupper($request->query->get('direction', 'ASC'));
    
        // Define allowed sorting fields to prevent SQL injection
        $allowedSortFields = ['prixLocation', 'dateDebut', 'dateFin'];
        if (!in_array($sort, $allowedSortFields)) {
            return $this->json(['success' => false, 'message' => 'Invalid sorting field'], 400);
        }
    
        if (!in_array($direction, ['ASC', 'DESC'])) {
            return $this->json(['success' => false, 'message' => 'Invalid sorting direction'], 400);
        }
    
        // Fetch locations from repository
        try {
            $locations = $locationRepository->searchLocations($minPrix, $maxPrix, $sort, $direction);
    
            if (empty($locations)) {
                return $this->json([
                    'success' => false,
                    'message' => 'No locations found within the specified price range.',
                    'data' => []
                ], 200);
            }
    
            // Format data for frontend
            $data = array_map(fn($location) => [
                'id' => $location->getId(),
                'dateDebut' => $location->getDateDebut()?->format('Y-m-d'),
                'dateFin' => $location->getDateFin()?->format('Y-m-d'),
                'prixLocation' => $location->getPrixLocation(),
                'terrain' => [
                    'id' => $location->getTerrain()?->getId(),
                    'localisation' => $location->getTerrain()?->getLocalisation(),
                ],
            ], $locations);
    
            return $this->json([
                'success' => true,
                'message' => count($data) . ' locations found',
                'data' => $data
            ], 200, [], ['json_encode_options' => JSON_PRETTY_PRINT]);
    
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'An error occurred while fetching locations.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    #[Route('/{id}/pdf', name: 'location_pdf', methods: ['GET'])]
    public function generateLocationPdf(Location $location): Response
    {
        $html = $this->renderView('location/pdf.html.twig', ['location' => $location]);
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

        if (!file_exists($pdfPath)) {
            return $this->json(['error' => 'Failed to generate contract'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->file($pdfPath, 'contract.pdf');
    }

    #[Route('/locations/charts', name: 'location_charts', methods: ['GET'])]
    public function charts(Request $request, LocationRepository $locationRepository): JsonResponse
    {
        $status = $request->query->get('status', null);
        $paymentMethod = $request->query->get('paymentMethod', null);

        if ($status) {
            $locations = $locationRepository->findByStatus($status);
        } elseif ($paymentMethod) {
            $locations = $locationRepository->findByPaymentMethod($paymentMethod);
        } else {
            $locations = $locationRepository->findAll();
        }

        $chartData = [['Localisation', 'Prix de Location']];
        $tableData = [];

        foreach ($locations as $location) {
            $chartData[] = [
                $location->getTerrain()->getLocalisation(),
                $location->getPrixLocation()
            ];

            $tableData[] = [
                'id' => $location->getId(),
                'localisation' => $location->getTerrain()->getLocalisation(),
                'dateDebut' => $location->getDateDebut()->format('Y-m-d'),
                'dateFin' => $location->getDateFin()->format('Y-m-d'),
                'prixLocation' => $location->getPrixLocation(),
                'modePaiement' => $location->getModePaiement(),
                'statut' => $location->getStatut()
            ];
        }

        return $this->json([
            'success' => true,
            'chartData' => $chartData,
            'tableData' => $tableData
        ]);
    }
}
