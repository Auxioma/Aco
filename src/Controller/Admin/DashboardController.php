<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Feedback;
use App\Entity\Metier;
use App\Entity\Services;
use App\Entity\Slider;
use App\Entity\Teams;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/adminVBqWvQy', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Acoproprete');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Categories', 'fas fa-user', Category::class);
            yield MenuItem::linkToCrud('Slider', 'fas fa-user', Slider::class);
            yield MenuItem::linkToCrud('Metier', 'fas fa-user', Metier::class);
            yield MenuItem::linkToCrud('Services', 'fas fa-user', Services::class);
            yield MenuItem::linkToCrud('Equipe', 'fas fa-user', Teams::class);
            yield MenuItem::linkToCrud('Feedback', 'fas fa-user', Feedback::class); 
        }


    }
}
