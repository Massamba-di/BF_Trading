<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/payment')]
final class PaymentController extends AbstractController
{
    #[Route('/create-intent', name: 'app_payment_create_intent', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function createIntent(Request $request): JsonResponse
    {
        // Récupérer les données de la réservation depuis la session
        $session = $request->getSession();
        $reservationData = $session->get('reservation_data');

        if (!$reservationData) {
            return new JsonResponse(['error' => 'Aucune réservation en cours'], 400);
        }

        // Configurer Stripe avec la clé secrète
        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        try {
            // Créer le PaymentIntent avec le montant en centimes
            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($reservationData['total'] * 100), // Convertir en centimes
                'currency' => 'eur',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'vehicule_id' => $reservationData['vehicule_id'],
                    'date_debut' => $reservationData['date_debut'],
                    'date_fin' => $reservationData['date_fin'],
                ],
            ]);

            return new JsonResponse([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/confirm', name: 'app_payment_confirm')]
    #[IsGranted('ROLE_USER')]
    public function confirm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $reservationData = $session->get('reservation_data');

        if (!$reservationData) {
            $this->addFlash('error', 'Aucune réservation à confirmer');
            return $this->redirectToRoute('app_main');
        }

        // Créer la réservation en base
        $reservation = new Reservation();
        $reservation->setDateDebut(new \DateTime($reservationData['date_debut']));
        $reservation->setDateFin(new \DateTime($reservationData['date_fin']));
        $reservation->setTotal($reservationData['total']);

        // Récupérer les entités liées
        $vehicule = $entityManager->getRepository(\App\Entity\Vehicules::class)->find($reservationData['vehicule_id']);
        $adresse = $entityManager->getRepository(Adresses::class)->find($reservationData['adresse_id']);
        $user = $this->getUser();

        $reservation->setVehicule($vehicule);
        $reservation->setAdresses($adresse);
        $reservation->setUser($user);

        $entityManager->persist($reservation);
        $entityManager->flush();

        // Nettoyer la session
        $session->remove('reservation_data');

        $this->addFlash('success', 'Réservation confirmée et payée avec succès !');
        return $this->redirectToRoute('app_main');
    }

    #[Route('/cancel', name: 'app_payment_cancel')]
    public function cancel(Request $request): Response
    {
        $request->getSession()->remove('reservation_data');
        $this->addFlash('warning', 'Paiement annulé');
        return $this->redirectToRoute('app_main');
    }

    #[Route('/', name: 'app_payment')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $reservationData = $session->get('reservation_data');

        if (!$reservationData) {
            $this->addFlash('error', 'Aucune réservation en cours');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('payment/index.html.twig', [
            'reservation' => $reservationData,
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);
    }
}
