<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Model360Controller extends AbstractController
{
    #[Route('/360-view', name: '360_view')]
    public function index(): Response
    {
        return $this->render('model360/index.html.twig');
    }
}
