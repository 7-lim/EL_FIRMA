<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, redirigez-le (ici, vers la page d'accueil ou un autre template)
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // Récupère l'erreur de connexion (s'il y en a une)
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupère le dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/redirect', name: 'custom_redirect')]
    public function redirectAfterLogin(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login    ');
        }

        // Redirige en fonction des rôles de l'utilisateur
        $roles = $user->getRoles();
        if (in_array('ROLE_ADMIN', $roles, true)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('home');
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // La déconnexion est gérée par Symfony via la configuration de sécurité.
        throw new \LogicException('Cette méthode ne doit pas être appelée directement.');
    }
}
