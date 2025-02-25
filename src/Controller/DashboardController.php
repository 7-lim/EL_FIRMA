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
        // Récupération des 5 terrains les plus récents
        $terrains = $terrainRepository->findBy([], ['id' => 'DESC'], 5);
        $totalTerrains = count($terrainRepository->findAll());

        // Récupération des 5 locations les plus récentes
        $locations = $locationRepository->findBy([], ['id' => 'DESC'], 5);
        $totalLocations = count($locationRepository->findAll());

        // Récupération du nombre total d'utilisateurs
        $totalUsers = count($utilisateurRepository->findAll());

        return $this->render('dashboard/index.html.twig', [
            'terrains'       => $terrains,
            'totalTerrains'  => $totalTerrains,
            'locations'      => $locations,
            'totalLocations' => $totalLocations,
            'totalUsers'     => $totalUsers,
        ]);
    }
}
