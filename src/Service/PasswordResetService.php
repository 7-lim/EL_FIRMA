<?php
namespace App\Service;

use App\Entity\ResetPasswordRequest;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class PasswordResetService
{
    private $entityManager;
    private $mailer;
    private $tokenGenerator;
    private $urlGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->urlGenerator = $urlGenerator;
    }

    public function sendPasswordResetEmail(Utilisateur $user): void
    {
        $token = $this->tokenGenerator->generateToken();

        $resetPasswordRequest = new ResetPasswordRequest();
        $resetPasswordRequest->setUser($user);
        $resetPasswordRequest->setToken($token);
        $resetPasswordRequest->setExpiresAt(new \DateTime('+1 hour'));

        $this->entityManager->persist($resetPasswordRequest);
        $this->entityManager->flush();

        // Génération de l'URL avec le router
        $resetUrl = $this->urlGenerator->generate(
            'reset_password',
            ['token' => $token],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $email = (new Email())
            ->from('no-reply@elfirma.com')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->html(sprintf('<p>Pour réinitialiser votre mot de passe, cliquez <a href="%s">ici</a>.</p>', $resetUrl));

        $this->mailer->send($email);
    }
}