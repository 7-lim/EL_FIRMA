<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; // Import the Request class
use App\Repository\UtilisateurRepository;


final class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/products', name: 'products')]
    public function products(): Response
    {
        return $this->render('products.html.twig');
    }

    #[Route('/store', name: 'store')]
    public function store(): Response
    {
        return $this->render('store.html.twig');
    }

    #[Route('/features', name: 'features')]
    public function features(): Response
    {
        return $this->render('features.html.twig');
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('blog.html.twig');
    }

    #[Route('/testimonial', name: 'testimonial')]
    public function testimonial(): Response
    {
        return $this->render('testimonial.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }

    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        return $this->render('services.html.twig');
    }

    #[Route('/terms', name: 'terms')]
    public function terms(): Response
    {
        return $this->render('terms.html.twig');
    }

    #[Route('/support', name: 'support')]
    public function support(): Response
    {
        return $this->render('support.html.twig');
    }

    #[Route('/404', name: '404')]
    public function notFound(): Response
    {
        return $this->render('404.html.twig');
    }

    #[Route('/dashboardfrs', name: 'dashboardFrs')]
    public function dashboardFrs(): Response
    {
        return $this->render('baseFournisseur.html.twig');
    }

    // #[Route('/dbfrsevents', name: 'dashboardevents')]
    // public function dbFournisseurEvents(): Response
    // {
    //     return $this->render('dbFournisseurEvents.html.twig');
    // }
    
 
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
    $searchTerm = $request->query->get('search');
    $utilisateurs = $searchTerm
        ? $utilisateurRepository->findByNom($searchTerm) // Custom repository method
        : $utilisateurRepository->findAll();

    return $this->render('dashboardadmin.html.twig', [
        'utilisateurs' => $utilisateurs,
    ]);
    }

    

    #[Route('/back', name: 'back')]
    public function back(): Response
    {
        return $this->render('back.html.twig');
    } 
}