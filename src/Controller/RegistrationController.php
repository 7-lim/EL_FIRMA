<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        // Create the form with a new Utilisateur as the initial data
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);

        // Handle the POST data
        $form->handleRequest($request);

        // If form is submitted & valid, proceed
        if ($form->isSubmitted() && $form->isValid()) {
            // 1) The mapped fields are already in $user at this point.

            // 2) Handle the plain password (unmapped field)
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // 3) Handle the user_type (unmapped field) to set roles or other logic
            $userTypeValue = $form->get('user_type')->getData();
            if ($userTypeValue === 'fournisseur') {
                // e.g. give them ROLE_USER, or a special role if you prefer
                $user->setRoles(['ROLE_USER']);
            } else {
                // e.g. 'agriculteur'
                $user->setRoles(['ROLE_USER']);
            }

            // 4) Persist to DB
            $em->persist($user);
            $em->flush();

            // 5) Redirect to login
            return $this->redirectToRoute('app_login');
        }

        // Render the form (which is part of your 'Sign Up' section)
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
