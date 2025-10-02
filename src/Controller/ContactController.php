<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\EmailServives;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true)]
    public function index(Request $request, EmailServives $email): Response
    {
        // retourne les valeur du breadcrumb
        $breadcrumb = [
            'Titre' => 'Contact',
            'Slug' => 'contact'
        ];

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        // je récupère les données du formulaire
        $form->handleRequest($request);

        // je vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $email->sendEmail($form);
        }
        

        return $this->render('contact/contact.html.twig', [
            'services' => $breadcrumb,
            'form' => $form->createView(),
        ]);
    }
}