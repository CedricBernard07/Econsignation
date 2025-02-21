<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class ParcoursController extends AbstractController
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    //charge la page 1
    #[Route('/parcours', name: 'app_parcours')]
    public function index()
    {
        // Réinitialisation du tableau de score à chaque chargement de la page 1
        $this->session->set('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0, 'etape4' => 0]);

        return $this->render('parcours/page1.html.twig', [
            'score' => $this->session->get('score'),
        ]);
    }


    #[Route('/parcours/page2', name: 'app_page2')]
    public function page2()
    {
        // Récupérer la session
        $score = $this->session->get('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0, 'etape4' => 0]);

        return $this->render('parcours/page2.html.twig', [
            'score' => $score,
        ]);
    }

    #[Route('/parcours/page3', name: 'app_page3')]
    public function page3()
    {
        $score = $this->session->get('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0, 'etape4' => 0]);

        return $this->render('parcours/page3.html.twig', [
            'score' => $score,
        ]);
    }

    #[Route('/parcours/page4', name: 'app_page4')]
    public function page4()
    {
        $score = $this->session->get('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0, 'etape4' => 0]);

        return $this->render('parcours/page4.html.twig', [
            'score' => $score,
        ]);
    }




    //update score toutes étapes
    #[Route('/parcours/update-score', name: 'update_score', methods: ['POST'])]
    public function updateScore(Request $request): JsonResponse
    {
        $score = $this->session->get('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0, 'etape4' => 0]);

        // Récupération des données envoyées via AJAX
        $data = json_decode($request->getContent(), true);
        if (isset($data['etape']) && array_key_exists($data['etape'], $score)) {
            $score[$data['etape']] = 1;
            $this->session->set('score', $score);
        }

        return new JsonResponse(['score' => $score]);
    }


}


