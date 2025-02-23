<?php


// src/Controller/LoginController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\RegistrationFormType;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        // Si l'utilisateur est déjà connecté, redirigez-le en fonction de son rôle
        if ($this->getUser()) {
            return $this->redirectBasedOnRole();
        }

        // Gestion des erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Create the registration form
        $registrationForm = $this->createForm(RegistrationFormType::class);

        return $this->render('registration/register.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'registrationForm' => $registrationForm->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode peut être vide, elle sera interceptée par le firewall
    }

    private function redirectBasedOnRole(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        // Rediriger en fonction du rôle
        if (in_array('ROLE_FOURNISSEUR', $roles)) {
            return $this->redirectToRoute('dashboardFrs');
        } elseif (in_array('ROLE_EXPERT', $roles) || in_array('ROLE_AGRICULTEUR', $roles)) {
            return $this->redirectToRoute('home');
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            return $this->redirectToRoute('app_dashboard');
        }

        // Redirection par défaut pour les autres rôles
        return $this->redirectToRoute('/');
    }
}