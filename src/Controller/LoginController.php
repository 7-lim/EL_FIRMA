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
        // If user is already logged in, redirect them
        if ($this->getUser()) {
            return $this->redirectToRoute('custom_redirect');
        }

        // Get the login error if any
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last entered username
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/redirect', name: 'custom_redirect')]
    public function redirectAfterLogin(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles, true)) {
            // Admin route
            return $this->redirectToRoute('dashboard');
        }

        // By default, ROLE_USER => home
        return $this->redirectToRoute('home');
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // This is handled by Symfony, so the method should never be called
        throw new \LogicException('This method should not be called directly.');
    }
}
