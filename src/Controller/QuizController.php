<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'quiz')]
    public function index(Request $request): Response
    {
        // Liste des questions et réponses possibles
        $questions = [
            [
                'question' => "Quel est la capitale de la France ?",
                'options' => ["Lyon", "Marseille", "Paris", "Bordeaux"],
                'answer' => "Paris"
            ],
            [
                'question' => "Combien font 2 + 2 ?",
                'options' => ["3", "4", "5", "6"],
                'answer' => "4"
            ],
            [
                'question' => "Quelle est la couleur du ciel par temps clair ?",
                'options' => ["Rouge", "Bleu", "Vert", "Jaune"],
                'answer' => "Bleu"
            ]
        ];

        // Vérification des réponses si le formulaire est soumis
        $score = null;
        if ($request->isMethod('POST')) {
            $score = 0;
            $responses = $request->request->all();
            foreach ($questions as $index => $q) {
                if (isset($responses["question$index"]) && $responses["question$index"] === $q['answer']) {
                    $score++;
                }
            }
        }

        return $this->render('quiz/index.html.twig', [
            'questions' => $questions,
            'score' => $score
        ]);
    }
}

