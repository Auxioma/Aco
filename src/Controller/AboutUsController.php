<?php

namespace App\Controller;

use DateInterval;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\EmailServives;
use App\Repository\MetierRepository;
use App\Repository\FeedbackRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutUsController extends AbstractController
{

    private $metier;
    private $feedback;

    public function __construct(MetierRepository $metier, FeedbackRepository $feedback)
    {
        $this->metier = $metier;
        $this->feedback = $feedback;
    }

    #[Route('/notre-histoire', name: 'app_notre_histoire')]
    #[Cache(public: true, maxage: 3600, mustRevalidate: true)]
    public function index(EmailServives $email, CacheInterface $cache, Request $request): Response
    {
        // retourne les valeur du breadcrumb
        $breadcrumb = [
            'Titre' => 'Notre histoire',
            'Slug' => 'notre-histoire'
        ];

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        // si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $email->sendEmail($form);
        }

        /**
         * Je vais utilisé le system de cache de symfony pour mettre en cache la page 
         */
        $metier = $cache->get('metier', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->metier->findAll();
        });
        
        $avis = $cache->get('avis', function (ItemInterface $item) {
            $item->expiresAfter(DateInterval::createFromDateString('1 month'));
            return $this->feedback->findby([], ['id' => 'DESC'], 8);
        });
        

        return $this->render('pages/about-us.html.twig', [
            'services' => $breadcrumb,
            'metiers' => $metier,
            'form' => $form->createView(),
            'avis' => $avis,
        ]);
    }
}