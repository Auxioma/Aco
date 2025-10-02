<?php

namespace App\Controller;

use DateInterval;
use App\Repository\MetierRepository;
use App\Repository\FeedbackRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NettoyageController extends AbstractController
{

    private $metier;
    private $feedback;

    public function __construct(MetierRepository $metier, FeedbackRepository $feedback)
    {
        $this->metier = $metier;
        $this->feedback = $feedback;
    }

    #[Route('/le-nettoyage', name: 'app_nettoyage')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true, expires: '+1 hour')]
    public function index(CacheInterface $cache): Response
    {
        // retourne les valeur du breadcrumb
        $breadcrumb = [
            'Titre' => 'Nos services de nettoyage',
            'Slug' => 'le-nettoyage'
        ];

        /**
         * je met en cache la page 
         */
        $metiers = $cache->get('metiers', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->metier->findAll();
        });

        $feedback = $cache->get('feedback', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->feedback->findby([], ['id' => 'DESC'], 8);
        });

        return $this->render('services/service-list.html.twig', [
            'services' => $breadcrumb,
            'metiers' => $metiers,
            'avis' => $feedback,
        ]);
    }
}