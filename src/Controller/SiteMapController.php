<?php

namespace App\Controller;

use DateTime;
use App\Repository\CategoryRepository;
use App\Repository\MetierRepository;
use App\Repository\ServicesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteMapController extends AbstractController
{
    #[Route('/sitemapcategories.xml', name: 'app_sitemap_categories', format: 'xml')]
    public function categorie(Request $request, CategoryRepository $categorie): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        
        $urls = [];
        foreach ($categorie->findAll() as $cat) {
            // genete URL for this category avc le nom des routes
            $urls[] = [
                'loc' => $this->generateUrl($cat->getSlug()),
                'lastmod' => new DateTime(),
                'changefreq' => 'weekly',
                'priority' => '0.8' 
            ];
        }
        $response = new Response(
            $this->renderView('sitemap/sitemap.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

    #[Route('/sitemapmetier.xml', name: 'app_sitemap_metier', format: 'xml')]
    public function metier(Request $request, MetierRepository $metier): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        
        $urls = [];

        foreach ($metier->findAll() as $met) {
            $images = [
                'loc' => '/images/breadcrumb/' . $met->getSlug() . '.png',
                'title' => $met->getTitre()    
            ];

            $urls[] = [
                'loc' => $this->generateUrl('app_metier', ['Slug' => $met->getSlug()]),
                'lastmod' => new DateTime(),
                'changefreq' => 'weekly',
                'priority' => '0.8' ,
                'image' => $images
            ];
        }
        $response = new Response(
            $this->renderView('sitemap/sitemap.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

    #[Route('/sitemapservice.xml', name: 'app_sitemap_service', format: 'xml')]
    public function service(Request $request, ServicesRepository $services): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        
        $urls = [];

        foreach ($services->findAll() as $service) {
            
            $images = [
                'loc' => '/images/breadcrumb/' . $service->getSlug() . '.png',
                'title' => $service->getDescription()   
            ];
            $urls[] = [
                'loc' => $this->generateUrl('app_services', [
                    'Slug' => $service->getSlug(),
                    'categorie' => $service->getMetier()->getSlug()
                ]),
                'lastmod' => new DateTime(),
                'changefreq' => 'weekly',
                'priority' => '0.8' ,
                'image' => $images
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/sitemap.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

}
