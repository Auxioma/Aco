<?php

namespace App\Controller\_partials;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends AbstractController
{
    Public function Menu(CategoryRepository $catagory): Response
    {
        return $this->render('_partials/_header_home.html.twig', [
            'categories' => $catagory->findAll(),
        ]);
    }

    Public function MenuMobileHome(CategoryRepository $catagory): Response
    {
        return $this->render('_partials/_menu_mobile_home.html.twig', [
            'categories' => $catagory->findAll(),
        ]);
    }

    Public function AutreQueLaHomepage(CategoryRepository $catagory): Response
    {
        return $this->render('_partials/_header.html.twig', [
            'categories' => $catagory->findAll(),
        ]);
    }

    Public function AutreQueLaHomepageMobile(CategoryRepository $catagory): Response
    {
        return $this->render('_partials/_menu_mobile.html.twig', [
            'categories' => $catagory->findAll(),
        ]);
    }

}