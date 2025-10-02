<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NosEngagementController extends AbstractController
{
    #[Route('/nos-engagements', name: 'app_nos_engagement')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true, expires: '+1 hour')]
    public function index(): Response
    {
        // retourne les valeur du breadcrumb
        $breadcrumb = [
            'Titre' => 'nos engagements',
            'Slug' => 'nos-engagements'
        ];

        return $this->render('services/nos-engagements.html.twig', [
            'services' => $breadcrumb,
        ]);
    }
}