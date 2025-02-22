<?php

namespace App\Controller;

use App\Entity\Administrateur; // Changed from Utilisateur to Administrateur to ensure it's a concrete class
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // The logout is managed by Symfony (security.yaml). This method is never executed.
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/create-user', name: 'create_user')]
    public function createUser(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Using Administrateur instead of Utilisateur to avoid instantiating an abstract class
        $user = new Administrateur();
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']); // Changed to ROLE_ADMIN for clarity
        $hashedPassword = $passwordHasher->hashPassword($user, '123456');
        $user->setPassword($hashedPassword);
        $user->setNom('Admin');
        $user->setPrenom('Test');
        
        // Ensure the phone number is valid (must be 8 digits)
        $user->setTelephone('12345678'); // Adjusted to an 8-digit format

        $user->setActif(true); // Ensure this field exists in the entity

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Admin user created successfully!');
    }
}
