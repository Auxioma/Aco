<?php

namespace App\Controller;

use App\Repository\MenuBlogRepository;
use App\Repository\ArticleBlogRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function list($category, MenuBlogRepository $menu, PaginatorInterface $paginator, Request $request): Response
    {
        $articles = $menu->findBy(
            ['slug' => $category],   
            ['id' => 'ASC']         
        );

        $breadcrumb = [
            'Titre' => $articles[0]->getName(),
            'Slug' => 'blog'
        ];

        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            1 /* limit per page */
        );

        return $this->render('blog/list.html.twig', [
            'services' => $breadcrumb,
            'articles' => $pagination,
            'menus' => $menu->findAll(),
        ]);
    }
}
