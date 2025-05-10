<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Form\AdminFormType;
use App\Repository\AdministrateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/homeadmin', name: 'homeadmin')]
    #[IsGranted('PUBLIC_ACCESS')]
    public function homeadmin(): Response
    {
        return $this->render('admin/homeadmin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    public function dashboard(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/create', name: 'admin_create')]
    #[IsGranted('PUBLIC_ACCESS')]
    public function createAdmin(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        // Instanciation de la classe concrète Administrateur (l'entité abstraite Utilisateur ne doit jamais être instanciée directement)
        $admin = new Administrateur();

        // Création du formulaire lié à l'objet $admin
        $form = $this->createForm(AdminFormType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du mot de passe brut (champ unmapped) et hachage
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($admin, $plainPassword);
            $admin->setPassword($hashedPassword);

            // Définition des rôles et du type (ces champs sont gérés dans l'entité)
            $admin->setRoles(['ROLE_ADMIN']);
            //$admin->setType('Administrateur');

            // Persistance dans la base de données ; la colonne discriminante (disc) sera automatiquement renseignée par Doctrine
            $entityManager->persist($admin);
            $entityManager->flush();

            $this->addFlash('success', 'Administrateur créé avec succès !');
            return $this->redirectToRoute('admin_list');
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/list', name: 'admin_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function listAdmins(AdministrateurRepository $administrateurRepository): Response
    {
        $admins = $administrateurRepository->findAll();

        return $this->render('admin/list.html.twig', [
            'admins' => $admins,
        ]);
    }
}