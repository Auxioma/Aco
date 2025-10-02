<?php

namespace App\Controller;

use App\Repository\ArticleBlogRepository;
use App\Repository\MenuBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/nettoyage-entreprise/chablais/haute-savoie/{category}/{slug}', name: 'app_blog_detail')]
    public function index($slug, ArticleBlogRepository $blog, MenuBlogRepository $menu): Response
    {
        $articles = $blog->findOneBy(['slug' => $slug]);

        $breadcrumb = [
            'Titre' => $articles->getName(),
            'Slug' => 'blog'
        ];

        return $this->render('blog/index.html.twig', [
            'services' => $breadcrumb,
            'articles' => $articles,
            'menus' => $menu->findAll(),
        ]);
    }


    #[Route('/nettoyage-entreprise/chablais/haute-savoie/{category}', name: 'app_blog_list')]
    public function list($category, MenuBlogRepository $menu): Response
    {
        $articles = $menu->findBy(
            ['slug' => $category],   
            ['id' => 'DESC']         
        );

        $breadcrumb = [
            'Titre' => $articles[0]->getName(),
            'Slug' => 'blog'
        ];

        return $this->render('blog/list.html.twig', [
            'services' => $breadcrumb,
            'articles' => $articles,
            'menus' => $menu->findAll(),
        ]);
    }
}
