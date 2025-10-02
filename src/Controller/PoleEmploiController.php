<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Services\PoleEmploiServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PoleEmploiController  extends AbstractController
{
    #[Route('/emploi', name: 'app_emplois')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true, expires: '+1 hour')]
    public function index(PoleEmploiServices $job, CategoryRepository $categories): Response
    {
        $ResultJob = $job->get($query ='');
        $ResultJob = json_decode($ResultJob);

        $breadcrumb = [
            'Titre' => 'Emploi Store via Pole Emploi',
            'Slug' => 'emploi-store'
        ];

        return $this->render('polemploi/PoleEmploi.html.twig', [
            'services' => $breadcrumb,
            'jobs' => $ResultJob->resultats,
            'categories' => $categories->findAll()
        ]);
    }
}