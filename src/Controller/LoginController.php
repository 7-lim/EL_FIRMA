<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\YourAuthenticator;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectBasedOnRole();
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
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
    
        
        error_log(print_r($roles, true));
    
        if (in_array('ROLE_ADMIN', $roles)) {
            return $this->redirectToRoute('app_dashboard');
        }
        if (in_array('ROLE_FOURNISSEUR', $roles)) {
            return $this->redirectToRoute('home');
        }
        if (in_array('ROLE_EXPERT', $roles)) {
            return $this->redirectToRoute('dbfrsevents');
        }
        if (in_array('ROLE_AGRICULTEUR', $roles)) {
            return $this->redirectToRoute('home');
        }
    
        // Default fallback
        return $this->redirectToRoute('home');
    }
    }
