<?php

namespace App\Controller;

use App\Entity\Agriculteur;
use App\Entity\Fournisseur;
use App\Entity\Expert;
use App\Entity\Administrateur;
use App\Entity\Utilisateur;
use App\Form\EditFormType;
use App\Form\RegistrationFormType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // Utilisez Response au lieu de RedirectResponse
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;




class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Création du formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $userType = $form->get('user_type')->getData();
    
            // En fonction du rôle, créer l'entité correspondante
            if ($userType === 'fournisseur') {
                $user = new Fournisseur();
                $user->setNomEntreprise($data['nomEntreprise']);
                $user->setIdFiscale($data['idFiscale']);
                $user->setCategorieProduit($data['categorieProduit']);
                $user->setRoles(['ROLE_FOURNISSEUR']);
            } elseif ($userType === 'expert') {
                $user = new Expert();
                $user->setDomaineExpertise($data['domaine_expertise']);
                $user->setRoles(['ROLE_EXPERT']);
            } elseif ($userType === 'agriculteur') {
                $user = new Agriculteur();
                $user->setAdresseExploitation($data['adresse_exploitation']);
                $user->setRoles(['ROLE_AGRICULTEUR']);
            } elseif ($userType === 'administrateur') {
                $user = new Administrateur();
                // Attribution explicite du rôle administrateur
                $user->setRoles(['ROLE_ADMIN']);
            }
    
            // Enregistrement des informations communes
            $user->setEmail($data['email']);
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setTelephone($data['telephone']);
    
            // Hachage du mot de passe avant de l'enregistrer
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
    
            // Sauvegarde de l'utilisateur dans la base de données
            $utilisateurRepository->save($user, true);
    
            // Redirection après l'enregistrement
            return $this->redirectToRoute('app_dashboard');
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

    return $this->render('dashboardadmin.html.twig', [
        'utilisateurs' => $utilisateurs,
    ]);
}










#[Route('/create-admin', name: 'create_admin')]
public function createAdmin(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
    $existingAdmin = $entityManager->getRepository(Administrateur::class)->findOneBy(['email' => 'admin@admin.com']);
    if ($existingAdmin) {
        return new Response('Admin already exists.');
    }

    $admin = new Administrateur();
    $admin->setEmail('admin@admin.com');
    $admin->setRoles(['ROLE_ADMIN']); // Ensure this is set
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

    // Déterminez le type d'utilisateur
    $userType = $utilisateur->getType(); // Assurez-vous que cette méthode existe dans l'entité Utilisateur

    $form = $this->createForm(EditFormType::class, $utilisateur, [
        'user_type' => $userType,
        'is_edit' => true,
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















#[Route('/utilisateurs/pdf', name: 'export_utilisateurs_pdf')]
public function exportPdf(Environment $twig, EntityManagerInterface $entityManager): Response
{
    // Récupérer les utilisateurs depuis la base de données
    $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findAll();

    // Générer le HTML à partir du template
    $html = $twig->render('pdf.html.twig', [ // Update the template path here
        'utilisateurs' => $utilisateurs
    ]);

    // Options pour Dompdf
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');

    // Initialiser Dompdf
    $dompdf = new Dompdf($pdfOptions);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // Retourner le fichier PDF en réponse
    return new Response($dompdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="utilisateurs.pdf"',
    ]);
}



#[Route('/admin/statistics', name: 'admin_statistics')]
public function statistics(UtilisateurRepository $utilisateurRepository): Response
{
    // Fetch the number of users for each role
    $roles = ['ROLE_EXPERT', 'ROLE_AGRICULTEUR', 'ROLE_FOURNISSEUR', 'ROLE_ADMIN'];
    $statistics = [];

    foreach ($roles as $role) {
        $statistics[$role] = $utilisateurRepository->countUsersByRole($role);
    }

    return $this->render('admin/statistics.html.twig', [
        'statistics' => $statistics,
    ]);
}
}
