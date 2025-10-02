<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\EmailServives;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MetierController extends AbstractController
{
    #[Route('/le-nettoyage/{Slug}', name: 'app_metier')]
    public function index(Request $Request, EmailServives $email, Metier $metier): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email->sendEmail($form);
        }

        return $this->render('services/service-details.html.twig', [
            'services' => $metier,
            'form' => $form->createView(),
        ]);
    }
}
