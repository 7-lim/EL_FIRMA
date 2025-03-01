<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use App\Service\OpenWeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TerrainController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private OpenWeatherService $weatherService;
    private SluggerInterface $slugger;

    public function __construct(
        EntityManagerInterface $entityManager,
        OpenWeatherService $weatherService,
        SluggerInterface $slugger
    ) {
        $this->entityManager = $entityManager;
        $this->weatherService = $weatherService;
        $this->slugger = $slugger;
    }

    #[Route('/terrain/{id}/weather', name: 'terrain_weather', methods: ['GET'])]
    public function showWeather(TerrainRepository $terrainRepository, int $id): Response
    {
        $terrain = $terrainRepository->find($id);

        if (!$terrain) {
            return new Response('<div class="alert alert-danger">Terrain not found</div>', 404);
        }

        if (!$terrain->getLatitude() || !$terrain->getLongitude()) {
            return new Response('<div class="alert alert-danger">GPS coordinates not available</div>', 400);
        }

        $weatherData = $this->weatherService->getWeather($terrain->getLatitude(), $terrain->getLongitude());

        if ($weatherData['cod'] !== 200) {
            return new Response('<div class="alert alert-danger">Unable to fetch weather data</div>', 500);
        }

        // Render the weather card HTML
        $html = $this->renderView('terrain/weather_card.html.twig', [
            'weather' => $weatherData,
        ]);

        return new Response($html);
    }

    #[Route('/terrain/{id}/forecast', name: 'terrain_forecast', methods: ['GET'])]
    public function showForecast(TerrainRepository $terrainRepository, int $id): Response
    {
        $terrain = $terrainRepository->find($id);

        if (!$terrain) {
            return new Response('<div class="alert alert-danger">Terrain not found</div>', 404);
        }

        if (!$terrain->getLatitude() || !$terrain->getLongitude()) {
            return new Response('<div class="alert alert-danger">GPS coordinates not available</div>', 400);
        }

        // Fetch 5-day forecast data
        $forecastData = $this->weatherService->getFiveDayForecast($terrain->getLatitude(), $terrain->getLongitude());

        if ($forecastData['cod'] !== "200") {
            return new Response('<div class="alert alert-danger">Unable to fetch forecast data</div>', 500);
        }

        // Render the forecast card HTML
        $html = $this->renderView('terrain/forecast_card.html.twig', [
            'forecast' => $forecastData,
        ]);

        return new Response($html);
    }

    #[Route(path: '/terrain/new', name: 'terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle photo upload
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $newFilename = $this->handlePhotoUpload($photoFile);
                $terrain->setPhoto($newFilename);
            }

            $this->entityManager->persist($terrain);
            $this->entityManager->flush();
            $this->addFlash('success', 'Terrain créé avec succès !');
            return $this->redirectToRoute('terrain_list');
        }

        return $this->render('terrain/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/terrains', name: 'terrain_list', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        $terrains = $terrainRepository->findAll();
        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    #[Route('/terrain/{id}', name: 'terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    #[Route('/terrain/{id}/edit', name: 'terrain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle photo upload
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $newFilename = $this->handlePhotoUpload($photoFile);
                $terrain->setPhoto($newFilename);
            }

            $this->entityManager->flush();
            $this->addFlash('success', 'Terrain modifié avec succès.');
            return $this->redirectToRoute('terrain_list');
        }

        return $this->render('terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Handles photo upload and returns the new filename.
     *
     * @param mixed $photoFile The uploaded file.
     * @return string The new filename.
     */
    private function handlePhotoUpload($photoFile): string
    {
        $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

        try {
            $photoFile->move(
                $this->getParameter('terrain_photos_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            $this->addFlash('error', 'Erreur lors de l\'upload de la photo.');
        }

        return $newFilename;
    }
}