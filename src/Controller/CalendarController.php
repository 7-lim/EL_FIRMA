<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends AbstractController
{
    public function load(Request $request): Response
    {
        // Get start/end dates from request
        $start = new \DateTime($request->get('start'));
        $end = new \DateTime($request->get('end'));
        
        // Return a JSON response (dummy data example)
        return $this->json([
            [
                'title' => 'Test Event',
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'allDay' => true
            ]
        ]);
    }
}