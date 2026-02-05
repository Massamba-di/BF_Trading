<?php

namespace App\Controller;



use App\Entity\Adresses;
use App\Entity\Reservation;
use App\Entity\Vehicules;
use App\Form\ReservationType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route('/{id}', name: 'app_reservation_index')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, Vehicules $vehicule, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        // Sécurité supplémentaire au cas où getUser() retourne null
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour faire une réservation.');
            return $this->redirectToRoute('app_login');
        }

        // Collection complète pour l'affichage dans le template
        $adresses = $user->getAdresses();

        // Une seule adresse pour la logique
        $adresse = $adresses->first() ?: null;

        // Vérifier que l'utilisateur a une adresse
        if (!$adresse) {
            $this->addFlash('error', 'Vous devez d\'abord enregistrer une adresse.');
            return $this->redirectToRoute('app_adresses_new');
        }

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Calculer le total automatiquement
            $dateDebut = $reservation->getDateDebut();
            $dateFin = $reservation->getDateFin();
            $nbJours = $dateDebut->diff($dateFin)->days;
            $total = (float) $vehicule->getPrixJour() * $nbJours;

            // Stocker les données de réservation en session au lieu de persister
            $session = $request->getSession();
            $session->set('reservation_data', [
                'vehicule_id' => $vehicule->getId(),
                'adresse_id' => $adresse->getId(),
                'date_debut' => $dateDebut->format('Y-m-d H:i:s'),
                'date_fin' => $dateFin->format('Y-m-d H:i:s'),
                'total' => $total,
            ]);

            // Rediriger vers la page de paiement
            return $this->redirectToRoute('app_payment');
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form,
            'vehicule' => $vehicule,
            'adresses' => $adresses,
        ]);
    }


    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();


        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
