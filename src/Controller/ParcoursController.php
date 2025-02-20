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

    #[Route('/parcours', name: 'app_parcours')]
    public function index()
    {
        // Initialisation du tableau de score en session
        if (!$this->session->has('score')) {
            $this->session->set('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0, 'etape4' => 0]);
        }

        return $this->render('parcours/page1.html.twig', [
            'score' => $this->session->get('score'),
        ]);
    }

    #[Route('/parcours/update-score', name: 'update_score', methods: ['POST'])]
    public function updateScore(Request $request): JsonResponse
    {
        $score = $this->session->get('score', ['etape1' => 0, 'etape2' => 0, 'etape3' => 0]);

        // Récupération des données envoyées via AJAX
        $data = json_decode($request->getContent(), true);
        if (isset($data['etape']) && array_key_exists($data['etape'], $score)) {
            $score[$data['etape']] = 1;
            $this->session->set('score', $score);
        }

        return new JsonResponse(['score' => $score]);
    }
}


