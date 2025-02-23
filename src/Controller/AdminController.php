<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Form\AdminFormType;
use App\Repository\AdministrateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function dashboard(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/create', name: 'admin_create')]
    #[IsGranted('ROLE_ADMIN')]
    public function createAdmin(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $admin = new Administrateur();
        $form = $this->createForm(AdminFormType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password before saving
            $hashedPassword = $passwordHasher->hashPassword($admin, $form->get('plainPassword')->getData());
            $admin->setPassword($hashedPassword);

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
    public function listAdmins(AdministrateurRepository $adminRepository): Response
    {
        $admins = $adminRepository->findAll();

        return $this->render('admin/list.html.twig', [
            'admins' => $admins,
        ]);
    }
}
