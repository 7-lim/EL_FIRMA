<?php

namespace App\Controller;

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe;

class StripeController extends AbstractController
{
    #[Route('/stripe/{ticketId<\d+>}', name: 'app_stripe')]
    public function index(int $ticketId, EntityManagerInterface $entityManager): Response
    {
        $ticket = $entityManager->getRepository(Ticket::class)->find($ticketId);
        if (!$ticket) {
            throw $this->createNotFoundException('Ticket not found');
        }

        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'ticket' => $ticket,
        ]);
    }

    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticketId = $request->request->get('ticketId');
        $ticket = $entityManager->getRepository(Ticket::class)->find($ticketId);
        if (!$ticket) {
            throw $this->createNotFoundException('Ticket not found');
        }

        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        try {
            $charge = Stripe\Charge::create([
                "amount" => $ticket->getPrix() * 100,
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'),
                "description" => "Payment for ticket #" . $ticket->getId(),
            ]);

            if ($charge->status === 'succeeded') {
                $ticket->setIsPaid(true);
                $entityManager->flush();
                $this->addFlash('success', 'Payment Successful!');
            } else {
                $this->addFlash('error', 'Payment Failed!');
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'Payment Failed! ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_ticket_show', ['id' => $ticketId], Response::HTTP_SEE_OTHER);
    }
}