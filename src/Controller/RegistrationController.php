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
        // Création du formulaire sans lier d'objet pour l'instant
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la valeur du type d'utilisateur (champ unmapped)
            $userTypeValue = $form->get('user_type')->getData();

            // En fonction du type, instancier la classe concrète appropriée
            if ($userTypeValue === 'fournisseur') {
                $user = new Fournisseur();
            } else {
                // Par défaut, nous créons un Agriculteur (ou adapter selon vos besoins)
                $user = new Agriculteur();
            }

            // Remplir manuellement les champs mappés
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setTelephone($form->get('telephone')->getData());
            // Vous pouvez également stocker le type dans l'entité si nécessaire
            $user->setType($userTypeValue);

            // Gérer le mot de passe brut (unmapped)
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Définir les rôles (stocké en JSON)
            $user->setRoles(['ROLE_USER']);

            // Persister l'utilisateur (la colonne 'disc' sera automatiquement renseignée)
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
