<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Services;
use App\Form\ContactType;
use App\Services\EmailServives;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ServicesController extends AbstractController
{
    #[Route('/le-nettoyage/{categorie}/{Slug}', name: 'app_services')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true, expires: '+1 hour')]
    public function index(Request $Request, EmailServives $email, Services $services): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email->sendEmail($form);
        }

        return $this->render('services/services.html.twig', [
            'services' => $services,
            'form' => $form->createView(),
        ]);
    }
}
