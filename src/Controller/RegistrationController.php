<?php

namespace App\Controller;

use App\Entity\Agriculteur;
use App\Entity\Fournisseur;
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
        // Create the form without binding it to an entity initially
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the user type value from the form (unmapped field)
            $userTypeValue = $form->get('user_type')->getData();

            // Instantiate the appropriate user entity based on the selected type
            if ($userTypeValue === 'fournisseur') {
                $user = new Fournisseur();
            } else {
                // Default to Agriculteur if no valid type is selected
                $user = new Agriculteur();
            }

            // Map the form data to the user entity
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setTelephone($form->get('telephone')->getData());

            // Optionally, store the user type in the entity if needed
            $user->setType($userTypeValue);

            // Handle the plain password (unmapped field)
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Set default roles (stored as JSON)
            $user->setRoles(['ROLE_USER']);

            // Persist the user (the 'disc' column will be automatically set due to inheritance)
            $em->persist($user);
            $em->flush();

            // Redirect to the login page after successful registration
            $this->addFlash('success', 'Registration successful! Please log in.');
            return $this->redirectToRoute('app_login');
        }

        // Render the registration form
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}