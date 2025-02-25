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
    public function index(
        TerrainRepository $terrainRepository,
        LocationRepository $locationRepository,
        UtilisateurRepository $utilisateurRepository
    ): Response {
        // Récupération des statistiques et des dernières entrées en base
        $terrains = $terrainRepository->findLatest(5);
        $totalTerrains = $terrainRepository->countTotal();

        $locations = $locationRepository->findLatest(5);
        $totalLocations = $locationRepository->countTotal();

        $totalUsers = $utilisateurRepository->countTotal();

        return $this->render('dashboard/index.html.twig', [
            'terrains'       => $terrains,
            'totalTerrains'  => $totalTerrains,
            'locations'      => $locations,
            'totalLocations' => $totalLocations,
            'totalUsers'     => $totalUsers,
        ]);
    }
}
