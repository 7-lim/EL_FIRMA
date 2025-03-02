<?php

namespace App\Controller;

use App\Repository\TerrainRepository;
use App\Repository\LocationRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(TerrainRepository $terrainRepository, LocationRepository $locationRepository): Response
    {
        // Get total terrains
        $totalTerrains = $terrainRepository->count([]);
        
        // Get terrains by status
        $terrainsDisponibles = $terrainRepository->countTerrainsByStatus('disponible');
        $terrainsEnAttente = $terrainRepository->countTerrainsByStatus('en attente');

        // Fetch recent terrains & locations
        $terrains = $terrainRepository->findBy([], ['id' => 'DESC'], 5);
        $locations = $locationRepository->findBy([], ['id' => 'DESC'], 5);

        return $this->render('dashboard/index.html.twig', [
            'totalTerrains' => $totalTerrains,
            'terrainsDisponibles' => $terrainsDisponibles,
            'terrainsEnAttente' => $terrainsEnAttente,
            'terrains' => $terrains,
            'locations' => $locations,
        ]);
    }
}

