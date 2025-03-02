<?php
// src/Controller/EventController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class EventController extends AbstractController
{
    #[Route('/calendar', name: 'calendar_events', methods: ['GET'])]
    public function fetchEvents(): JsonResponse
    {
        $events = [
            [
                'id' => 1,
                'title' => 'Réunion Projet',
                'start' => '2025-03-10T10:00:00',
                'end' => '2025-03-10T12:00:00',
                'color' => '#ff0000'
            ],
            [
                'id' => 2,
                'title' => 'Présentation Client',
                'start' => '2025-03-15T14:00:00',
                'end' => '2025-03-15T16:00:00',
                'color' => '#007bff'
            ]
        ];

        return $this->json($events);
    }
}
