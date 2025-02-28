<?php
// src/Controller/SecurityMailController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\PasswordResetService;
use App\Entity\Utilisateur;
use App\Entity\ResetPasswordRequest;

class SecurityMailController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/forgot-password", name="forgot_password")
     */
    public function forgotPassword(Request $request, PasswordResetService $passwordResetService): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

            if ($user) {
                $passwordResetService->sendPasswordResetEmail($user);
                $this->addFlash('success', 'Un email de réinitialisation a été envoyé.');
            } else {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
            }
        }

        return $this->render('security/forgot_password.html.twig');
    }

    /**
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordHasherInterface $passwordHasher): Response
    {
        $resetPasswordRequest = $this->entityManager->getRepository(ResetPasswordRequest::class)->findOneBy(['token' => $token]);

        if (!$resetPasswordRequest || $resetPasswordRequest->getExpiresAt() < new \DateTime()) {
            $this->addFlash('error', 'Le lien de réinitialisation est invalide ou a expiré.');
            return $this->redirectToRoute('forgot_password');
        }

        if ($request->isMethod('POST')) {
            $newPassword = $request->request->get('password');
            $user = $resetPasswordRequest->getUser();
            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));

            $this->entityManager->remove($resetPasswordRequest);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/reset_password.html.twig', ['token' => $token]);
    }
}