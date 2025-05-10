<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe;
 
class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(Request $request): Response
    {
        $prix = $request->query->get('prix', 5); // Default to 5 if not provided
        $session = $request->getSession();
        $paymentSuccessful = $session->get('payment_successful', false);
        $session->remove('payment_successful'); // Clear the session variable

        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'prix' => $prix,
            'payment_successful' => $paymentSuccessful,
        ]);
    }
 
 
    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request)
    {
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        $amount = $request->request->get('amount', 5) * 100; // Default to 5 if not provided
        Stripe\Charge::create ([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'),
                "description" => "Binaryboxtuts Payment Test"
        ]);
        $this->addFlash(
            'success',
            'Payment Successful!'
        );
        $request->getSession()->set('payment_successful', true);
        return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    }
}