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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class RegistrationController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        // Initialize error variable
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // CAPTCHA verification
            $captchaResponse = $request->request->get('g-recaptcha-response');
            $secretKey = $this->params->get('google_recaptcha_secret_key');

            if (!$this->verifyCaptcha($captchaResponse, $secretKey)) {
                $error = 'CAPTCHA verification failed. Please try again.';
                $this->addFlash('error', $error);
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                    'google_recaptcha_site_key' => $this->params->get('google_recaptcha_site_key'),
                    'error' => $error, // Pass the error variable
                ]);
            }

            // Existing user creation logic
            $data = $form->getData();
            $userType = $form->get('user_type')->getData();

            if ($userType === 'fournisseur') {
                $user = new Fournisseur();
                $user->setNomEntreprise($data['nomEntreprise']);
                $user->setIdFiscale($data['idFiscale']);
                $user->setCategorieProduit($data['categorieProduit']);
            } elseif ($userType === 'expert') {
                $user = new Expert();
                $user->setDomaineExpertise($data['domaine_expertise']);
            } elseif ($userType === 'agriculteur') {
                $user = new Agriculteur();
                $user->setAdresseExploitation($data['adresse_exploitation']);
            } elseif ($userType === 'administrateur') {
                $user = new Administrateur();
                $user->setRoles(['ROLE_ADMIN']);
            }

            $user->setEmail($data['email']);
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setTelephone($data['telephone']);

            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $utilisateurRepository->save($user, true);

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'google_recaptcha_site_key' => $this->params->get('google_recaptcha_site_key'),
            'error' => $error, // Pass the error variable
        ]);
    }
    private function verifyCaptcha(?string $captchaResponse, string $secretKey): bool
    {
        if (!$captchaResponse) {
            return false;
        }
    
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $secretKey,
                'response' => $captchaResponse,
            ]
        ]);
    
        $result = $response->toArray();
        return $result['success'] ?? false;
    }   


    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(UtilisateurRepository $utilisateurRepository): Response
    {
        $roles = ['ROLE_EXPERT', 'ROLE_AGRICULTEUR', 'ROLE_FOURNISSEUR', 'ROLE_ADMIN'];
        $statistics = [];

        foreach ($roles as $role) {
            $count = $utilisateurRepository->countUsersByRole($role);
            $statistics[$role] = $count;
        }

        return $this->render('admin/statistics.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'statistics' => $statistics,
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

        $userType = $utilisateur->getType();

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

    #[Route('/utilisateur/block/{id}', name: 'block_utilisateur')]
    public function blockUtilisateur(int $id, UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $utilisateur->setIsBlocked(true);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur bloqué avec succès.');
        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/utilisateur/unblock/{id}', name: 'unblock_utilisateur')]
    public function unblockUtilisateur(int $id, UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $utilisateur->setIsBlocked(false);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur débloqué avec succès.');
        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/utilisateurs/pdf', name: 'export_utilisateurs_pdf')]
    public function exportPdf(Environment $twig, EntityManagerInterface $entityManager): Response
    {
        $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findAll();

        $html = $twig->render('pdf.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="utilisateurs.pdf"',
        ]);
    }
}
