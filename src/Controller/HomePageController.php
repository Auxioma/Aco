<?php

namespace App\Controller;

use DateInterval;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ArticleBlogRepository;
use App\Services\EmailServives;
use App\Repository\TeamsRepository;
use App\Repository\MetierRepository;
use App\Repository\SliderRepository;
use App\Repository\FeedbackRepository;
use App\Repository\ServicesRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{

    private $Slider;
    private $metier;
    private $services;
    private $teams;
    private $avis;
    private $blog;

    public function __construct(SliderRepository $Slider, MetierRepository $metier, ServicesRepository $services, TeamsRepository $teams, FeedbackRepository $avis, ArticleBlogRepository $blog)
    {
        $this->Slider = $Slider;
        $this->metier = $metier;
        $this->services = $services;
        $this->teams = $teams;
        $this->avis = $avis;
        $this->blog = $blog;
    }

    #[Route('/', name: 'app_homepage')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true, expires: '+1 hour')]
    public function index(CacheInterface $cache, Request $Request, EmailServives $email): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email->sendEmail($form);
        } 


        /**
         * Je vais utilisé le system de cache de symfony pour mettre en cache la page d'accueil
         */
        $sliders = $this->Slider->findby([], ['id' => 'DESC'], 3);
     

        $metiers = $cache->get('metiers', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->metier->findAll();
        });

        $services = $cache->get('services', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->services->findAll();
        });

        $teams = $cache->get('teams', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->teams->findAll();
        });

        $avis = $cache->get('avis', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->avis->findby([], ['id' => 'DESC'], 3);
        });

        $blog = $this->blog->findby([], ['id' => 'DESC'], 3);

        return $this->render('home/homepage.html.twig', [
            'sliders' => $sliders,
            'metiers' => $metiers,
            'services' => $services,
            'teams' => $teams,
            'avis' => $avis,
            'form' => $form->createView(),
            'blogs' => $blog,
        ]);
    }
}
