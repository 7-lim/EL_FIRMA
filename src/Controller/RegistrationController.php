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
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        // Création du formulaire
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        // Vérification du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du type d'utilisateur
            $userType = $form->get('user_type')->getData();

            // Création de l'utilisateur selon son type
            if ($userType === 'agriculteur') {
                $user = new Agriculteur();
            } elseif ($userType === 'fournisseur') {
                $user = new Fournisseur();
                $user->setNomEntreprise($form->get('nomEntreprise')->getData());
                $user->setIdFiscale($form->get('idFiscale')->getData());
                $user->setCategorieProduit($form->get('categorieProduit')->getData());
            } else {
                throw new \Exception('Type d\'utilisateur invalide');
            }

            // Assignation des données communes
            $user->setEmail($form->get('email')->getData());
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setTelephone($form->get('telephone')->getData());

            // Hash du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($hashedPassword);

            // Persistance et enregistrement en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection après l'inscription
            return $this->redirectToRoute('app_login');
        }

        // Rendu du formulaire
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    
}
