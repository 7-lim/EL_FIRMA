<?php

namespace App\Controller;

use App\Entity\Utilisateur;
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

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->redirectToRoute('app_login');
    }

    #[Route('/create-user', name: 'create_user')]
    public function createUser(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new Utilisateur();
        $user->setEmail('azazazaz@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $passwordHasher->hashPassword($user, '123456');
        $user->setPassword($hashedPassword);
        $user->setNom('user');
        $user->setPrenom('test');
        $user->setTelephone('1234567890');
        $user->setType('user');
        // $user->setLocalisation(null); // Commented out as the method does not exist
        // $user->setNomEntreprise(null); // Commented out as the method does not exist
        //        $user->setIdFiscale(null); // Commented out as the method does not exist
        // $user->setDomaineExpertise(null); // Commented out as the method does not exist
        $user->setActif(true);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('User created successfully!');
    }
}
