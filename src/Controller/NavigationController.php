<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends AbstractController
{
    #[Route('/navigation/entree', name: 'app_navigation_entree')]
    public function index(): Response
    {
        return $this->render('navigation/entree.html.twig');
    }

    #[Route('/navigation/coffret-presence', name: 'app_navigation_coffret_presence')]
    public function coffretPresence(): Response
    {
        return $this->render('Navigation/coffretPresence.html.twig');
    }

    #[Route('/navigation/transformateur', name: 'app_navigation_transformateur')]
    public function transformateur(): Response
    {
        return $this->render('Navigation/transformateur.html.twig');
    }

    #[Route('/navigation/cableHTB', name: 'app_navigation_cable_HTB')]
    public function cableHTB(): Response
    {
        return $this->render('Navigation/cableHTB.html.twig');
    }

}
