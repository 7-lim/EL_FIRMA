<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TerrainRepository; // Add this to use TerrainRepository

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(TerrainRepository $terrainRepository): Response
    {
        $terrains = $terrainRepository->findBy([], ['id' => 'DESC'], 5); // Fetch recent 5 terrains
        $totalTerrains = count($terrainRepository->findAll());

        return $this->render('dashboard/index.html.twig', [
            'terrains' => $terrains,
            'totalTerrains' => $totalTerrains,
        ]);
    }
}
