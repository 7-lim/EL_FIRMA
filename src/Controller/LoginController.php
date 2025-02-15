<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
  
     #[Route('/login', name: 'app_login')]

    public function login()
    {
        // Si l'utilisateur est déjà connecté, on peut rediriger vers une autre page
        if ($this->getUser()) {
            return $this->redirectToRoute('/');  // Redirigez vers une page après le login
        }

        return $this->render('registration/register.html.twig');    
    }
}

