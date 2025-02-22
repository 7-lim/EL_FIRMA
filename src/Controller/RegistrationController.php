<?php

namespace App\Controller;

use App\Entity\Agriculteur;
use App\Entity\Fournisseur;
use App\Entity\Expert;
use App\Entity\Administrateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Création du formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $userType = $form->get('user_type')->getData(); // Récupère le rôle sélectionné
            $user = null;

            // En fonction du rôle, créer l'entité correspondante
            if ($userType === 'fournisseur') {
                $user = new Fournisseur();
                $user->setNomEntreprise($form->get('nomEntreprise')->getData());
                $user->setIdFiscale($form->get('idFiscale')->getData());
                $user->setCategorieProduit($form->get('categorieProduit')->getData());
            } elseif ($userType === 'expert') {
                $user = new Expert();
                $user->setDomaineExpertise($form->get('domaineExpertise')->getData());
            } elseif ($userType === 'agriculteur') {
                $user = new Agriculteur();
                $user->setAdresseExploitation($form->get('farm_size')->getData());
            } elseif ($userType === 'administrateur') {
                $user = new Administrateur();
            } else {
                throw new \Exception("Type d'utilisateur invalide.");
            }

            // Enregistrement des informations communes
            $user->setEmail($form->get('email')->getData());

            // Hachage du mot de passe avant l'enregistrement
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Sauvegarde de l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection après l'enregistrement
            return $this->redirectToRoute('home');
        }
    
        // Rendu du formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateurs = $utilisateurRepository->findAll();

        return $this->render('dashboard.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/create-admin', name: 'create_admin')]
    public function createAdmin(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Vérifier si l'admin existe déjà
        $existingAdmin = $entityManager->getRepository(Administrateur::class)->findOneBy(['email' => 'admin@admin.com']);
        if ($existingAdmin) {
            return new Response('Admin already exists.');
        }

        $admin = new Administrateur();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $passwordHasher->hashPassword($admin, '123456');
        $admin->setPassword($hashedPassword);

        $entityManager->persist($admin);
        $entityManager->flush();

        return new Response('Admin user created successfully!');
    }

    #[Route('/utilisateur/delete/{id}', name: 'delete_utilisateur')]
    public function deleteUtilisateur(int $id, UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $entityManager->remove($utilisateur);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/utilisateur/edit/{id}', name: 'edit_utilisateur')]
    public function editUtilisateur(int $id, Request $request, UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        // Vérifie la classe réelle de l'utilisateur et utilise les bonnes options
        $form = $this->createForm(RegistrationFormType::class, $utilisateur, [
            'is_edit' => true, // Indique qu'on est en mode édition
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('edit_utilisateur.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}