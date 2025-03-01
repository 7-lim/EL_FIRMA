<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewMessageNotification(string $recipientEmail, string $messageContent)
    {
        try {
            $email = (new Email())
                ->from('expediteur@example.com')
                ->to($recipientEmail)
                ->subject('Nouveau message reçu')
                ->html("
                    <p>Vous avez reçu un nouveau message :</p>
                    <blockquote>{$messageContent}</blockquote>
                    <p>Consultez votre discussion pour répondre.</p>
                ");
    
            $this->mailer->send($email);
    
            return true; // Succès
        } catch (TransportExceptionInterface $e) {
            // Log l'erreur (si Monolog est activé)
            error_log('Erreur d\'envoi d\'email : ' . $e->getMessage());
    
            return false; // Échec
        }
    }
}
