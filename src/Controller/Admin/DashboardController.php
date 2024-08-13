<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Entity\Pokemon;
use App\Entity\PokemonElement;
use App\Entity\Rarity;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(PokemonCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administrator interface');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Pokemon','fa fa-paw', Pokemon::class);
        yield MenuItem::linkToCrud('Location','fa fa-location', Location::class);
        yield MenuItem::linkToCrud('Pokemon Element','fa fa-leaf', PokemonElement::class);
        yield MenuItem::linkToCrud('Pokemon rarity','fa fa-star', Rarity::class);
        yield MenuItem::linkToCrud('User','fa fa-user', User::class);

//        return [
//        MenuItem::linkToCrud('Pokemon','fa fa-paw', Pokemon::class),
//        MenuItem::linkToCrud('Location','fa fa-location', Location::class),
//        MenuItem::linkToCrud('Pokemon Element','fa fa-leaf', PokemonElement::class),
//        MenuItem::linkToCrud('Pokemon rarity','fa fa-star', Rarity::class),
//        MenuItem::linkToCrud('User','fa fa-user', User::class),
//            ];
    }
}
