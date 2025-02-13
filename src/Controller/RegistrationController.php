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
use Symfony\Component\HttpFoundation\Response; // Utilisez Response au lieu de RedirectResponse
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher // Injection du service de hachage
    ): Response
    {
        // Création du formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $userType = $form->get('user_type')->getData(); // Récupère le rôle sélectionné
    
            // En fonction du rôle, créer l'entité correspondante
            if ($userType === 'fournisseur') {
                $user = new Fournisseur();
                $user->setNomEntreprise($data['company_name']);
                $user->setIdFiscale($data['id_fiscale']);
                $user->setCategorieProduit($data['category_product']);
            } elseif ($userType === 'expert') {
                $user = new Expert();
                $user->setDomaineExpertise($data['expertise_area']);
            } elseif ($userType === 'agriculteur') {
                $user = new Agriculteur();
                $user->setAdresseExploitation($data['farm_size']);
            } elseif ($userType === 'administrateur') {
                $user = new Administrateur();
                // Ajoutez des champs spécifiques à l'administrateur si nécessaire
            }
    
            // Enregistrement des informations communes
            $user->setEmail($data['email']);
            
            // Hachage du mot de passe avant de l'enregistrer
            $plainPassword = $form->get('plainPassword')->getData(); // Récupère le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
    
            // Sauvegarde de l'utilisateur dans la base de données
            $utilisateurRepository->save($user, true);
    
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
    // Check if admin already exists
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

    // Vérifie la classe réelle de l'utilisateur
    $form = $this->createForm(RegistrationFormType::class, $utilisateur, [
        'data_class' => get_class($utilisateur) // Permet d'utiliser la bonne classe concrète
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