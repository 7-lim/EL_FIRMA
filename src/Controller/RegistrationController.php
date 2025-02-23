<?php

namespace App\Controller;

use App\Entity\Agriculteur;
use App\Entity\Fournisseur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        // Create the registration form
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the selected user type
            $userType = $form->get('user_type')->getData();

            // Create the user based on the selected type
            if ($userType === 'agriculteur') {
                $user = new Agriculteur();
            } elseif ($userType === 'fournisseur') {
                $user = new Fournisseur();
                // Set additional fields for Fournisseur
                $user->setNomEntreprise($form->get('nomEntreprise')->getData());
                $user->setIdFiscale($form->get('idFiscale')->getData());
                $user->setCategorieProduit($form->get('categorieProduit')->getData());
            } else {
                throw new \Exception('Type d\'utilisateur invalide');
            }

            // Set common fields
            $user->setEmail($form->get('email')->getData());
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setTelephone($form->get('telephone')->getData());

            // Hash the password
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($hashedPassword);

            // Save the user to the database
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect to the login page after successful registration
            return $this->redirectToRoute('app_login');
        }

        // Render the registration form
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}