<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Model3DController extends AbstractController
{
    #[Route('/3d-view', name: '3d_view')]
    public function index(): Response
    {
        return $this->render('model3d/3d_view.html.twig');
    }
}
