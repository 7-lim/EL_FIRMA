<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Form\AdminFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LoginController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function redirectToLogin(): Response
    {
        return $this->redirectToRoute('app_login');
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Rediriger les utilisateurs connectés vers la bonne page
        if ($this->getUser()) {
            return $this->redirectToRoute('custom_redirect');
        }

        // Récupérer les erreurs d'authentification s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/redirect', name: 'custom_redirect')]
    public function redirectAfterLogin(): RedirectResponse
    {
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedException();
        }

        // Vérification du rôle et redirection appropriée
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            return $this->redirectToRoute('app_dashboard');
        }

        if (in_array('ROLE_AGRICULTEUR', $roles) || in_array('ROLE_FOURNISSEUR', $roles)) {
            return $this->redirectToRoute('app_home');
        }

        // Redirection par défaut en cas d'erreur
        return $this->redirectToRoute('app_login');
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // Symfony gère automatiquement la déconnexion, donc cette méthode ne sera jamais appelée.
    }

    #[Route('/admin/create', name: 'admin_create')]
    public function createAdmin(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $admin = new Administrateur();
        $form = $this->createForm(AdminFormType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($admin, $form->get('plainPassword')->getData());
            $admin->setPassword($hashedPassword);

            // Enregistrement en base de données
            $entityManager->persist($admin);
            $entityManager->flush();

            $this->addFlash('success', 'Administrateur créé avec succès !');
            return $this->redirectToRoute('app_login'); // Redirection après création
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
