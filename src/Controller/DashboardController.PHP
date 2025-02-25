<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        // Add security check to ensure only admins can access
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('dashboardadmin.html.twig');
    }
}