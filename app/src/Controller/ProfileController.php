<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, MailerInterface $mailer): Response

    {
        $user = $this->getUser();
        $adresse = $user->getAdresses();
        $reservation = $user->getReservations();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $email =(new Email());
            $email->from('noreply@votre-site.com');
            $email->to('bf_trading@admin.fr');
            $email->subject('subject');
            $email->html($this->renderView('emails/contact.html.twig', [
                'contact' => $contact,

            ]));


            $mailer->send($email);
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('app_profile');

        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'adresse' => $adresse,
            'reservation' => $reservation,
            'form' => $form,



        ]);
    }
}
