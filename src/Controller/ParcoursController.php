<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class ParcoursController extends AbstractController
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    /**
     * Initialise le tableau des scores avec toutes les étapes
     */
    private function getDefaultScore(): array
    {
        return [
            'etape1' => 0,
            'etape2' => 0,
            'etape3' => 0,
            'etape4' => 0,
            'etape5' => 0,
            // Ajouter d'autres étapes ici et seulement ici
        ];
    }

    /**
     * Page d'accueil du parcours - Réinitialisation du score
     */
    #[Route('/parcours', name: 'app_parcours')]
    #[Route('/parcours/page1', name: 'app_parcours_page1')]
    public function parcours(): Response
    {
        $this->session->set('score', $this->getDefaultScore());
        $tableData = $this->getTableData();
        return $this->render('parcours/page1.html.twig', ['tableData' => $tableData]);
    }

    /**
     * Affichage page 2
     */
    #[Route('/parcours/page2', name: 'app_page2')]
    public function page2(): Response
    {
        $score = $this->session->get('score', $this->getDefaultScore());
        $tableData = $this->getTableData();
        return $this->render('parcours/page2.html.twig', [
            'score' => $score,
            'tableData' => $tableData
        ]);
    }

    /**
     * Affichage page 3
     */
    #[Route('/parcours/page3', name: 'app_page3')]
    public function page3(): Response
    {
        $score = $this->session->get('score', $this->getDefaultScore());
        $tableData = $this->getTableData();
        return $this->render('parcours/page3.html.twig', [
            'score' => $score,
            'tableData' => $tableData
        ]);
    }

    /**
     * Affichage page 4
     */
    #[Route('/parcours/page4', name: 'app_page4')]
    public function page4(): Response
    {
        $score = $this->session->get('score', $this->getDefaultScore());
        $tableData = $this->getTableData();
        return $this->render('parcours/page4.html.twig', [
            'score' => $score,
            'tableData' => $tableData
        ]);
    }

    /**
     * Affichage page 5
     */
    #[Route('/parcours/page5', name: 'app_page5')]
    public function page5(): Response
    {
        $score = $this->session->get('score', $this->getDefaultScore());
        $tableData = $this->getTableData();
        return $this->render('parcours/page5.html.twig', [
            'score' => $score,
            'tableData' => $tableData
        ]);
    }

    /**
     * Mise à jour du score pour toutes les étapes
     */
    #[Route('/parcours/update-score', name: 'update_score', methods: ['POST'])]
    public function updateScore(Request $request): JsonResponse
    {
        $score = $this->session->get('score', $this->getDefaultScore());
        $data = json_decode($request->getContent(), true);

        if (!isset($data['etape']) || !array_key_exists($data['etape'], $score)) {
            return new JsonResponse(['error' => 'Étape invalide'], Response::HTTP_BAD_REQUEST);
        }

        // Mettre à jour le score
        $score[$data['etape']] = $data['value'];  //1 ou -1 selon succes ou echec transmis par le TWIG
        $this->session->set('score', $score);

        return new JsonResponse(['success' => true, 'score' => $score]);
    }

    /**
     * Page bilan du parcours
     */
    #[Route('/parcours/bilan', name: 'app_bilan')]
    public function bilan(): Response
    {
        return $this->render('parcours/bilan.html.twig');
    }

    /**
     * Récupération du score du parcours
     */
    #[Route('/parcours/get-score', name: 'get_score', methods: ['GET'])]
    public function getScore(): JsonResponse
    {
        $score = $this->session->get('score', $this->getDefaultScore());
        return new JsonResponse(['score' => $score]);
    }

    // tableau representant une fiche de consignation
    private function getTableData(): array
    {
        return [
            ['N°' => 1, 'Emplacement' => 'Transformateur', 'Opération' => 'Identifier', 'Validation' => ' '],
            ['N°' => 2, 'Emplacement' => 'Transformateur', 'Opération' => 'Choix des EPI', 'Validation' => ' '],
            ['N°' => 3, 'Emplacement' => 'Transformateur', 'Opération' => 'Mise a la terre', 'Validation' => ' '],
            ['N°' => 4, 'Emplacement' => 'Transformateur', 'Opération' => 'Question générale', 'Validation' => ' '],
            ['N°' => 5, 'Emplacement' => 'Salle Contrôle Commande', 'Opération' => 'Point de vigilance', 'Validation' => ' '],
        ];
    }

}
