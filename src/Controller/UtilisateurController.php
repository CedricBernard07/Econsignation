<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/session/set-nni/{nni}', name: 'session_set_nni', methods: ['POST'])]
    public function setNNISession(string $nni, Request $request): JsonResponse
    {
        $session = $request->getSession();
        $session->set('nni', $nni);

        return new JsonResponse(['message' => 'NNI enregistré en session']);
    }

    #[Route('/session/get-nni', name: 'session_get_nni', methods: ['GET'])]
    public function getNNISession(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $nni = $session->get('nni');

        if (!$nni) {
            return new JsonResponse(['error' => 'Aucun NNI en session'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['nni' => $nni]);
    }

    #[Route('/session/reset-nni', name: 'session_reset_nni', methods: ['POST'])]
    public function resetNNISession(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $session->remove('nni');

        return new JsonResponse(['message' => 'NNI supprimé de la session']);
    }


    #[Route('/db/check-nni/{nni}', name: 'db_check_nni', methods: ['GET'])]
    public function checkNNI(EntityManagerInterface $entityManager, string $nni): JsonResponse
    {
        $user = $entityManager->getRepository(Utilisateur::class)->find($nni);
        return new JsonResponse(['exists' => $user !== null]);
    }


    #[Route('/db/add-nni/{nni}', name: 'db_add_nni', methods: ['POST'])]
    public function addNNI(EntityManagerInterface $entityManager, string $nni): Response
    {
        $user = new Utilisateur();
        $user->setNni($nni);
        $user->setNombreDeTentatives(0);
        $user->setMeilleurScore(0);
        $user->setScoreMoyen(0);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response("Utilisateur ajouté", Response::HTTP_CREATED);
    }

    #[Route('/db/update-score/{nni}/{score}', name: 'db_update_score', methods: ['POST'])]
    public function updateScore(EntityManagerInterface $entityManager, string $nni, int $score): Response
    {
        $user = $entityManager->getRepository(Utilisateur::class)->find($nni);
        if (!$user) {
            return new Response("Utilisateur non trouvé", Response::HTTP_NOT_FOUND);
        }

        // Mise à jour du nombre de tentatives
        $ancien_tentatives = $user->getNombreDeTentatives();
        $user->setNombreDeTentatives($ancien_tentatives + 1);

        // Mise à jour du meilleur score
        if ($score > $user->getMeilleurScore()) {
            $user->setMeilleurScore($score);
        }

        // Mise à jour du score moyen
        $nouveauScoreMoyen = (($user->getScoreMoyen() * $ancien_tentatives) + $score) / ($ancien_tentatives + 1);
        $user->setScoreMoyen($nouveauScoreMoyen);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response("Score mis à jour", Response::HTTP_OK);
    }

}
