<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 50, unique: true)]
    private string $nni;

    #[ORM\Column(type: "integer")]
    private int $nombreDeTentatives = 0;

    #[ORM\Column(type: "integer")]
    private int $meilleurScore = 0;

    #[ORM\Column(type: "float")]
    private float $scoreMoyen = 0.0;

    // Getters et Setters
    public function getNni(): string { return $this->nni; }
    public function setNni(string $nni): self { $this->nni = $nni; return $this; }

    public function getNombreDeTentatives(): int { return $this->nombreDeTentatives; }
    public function setNombreDeTentatives(int $nombreDeTentatives): self { $this->nombreDeTentatives = $nombreDeTentatives; return $this; }

    public function getMeilleurScore(): int { return $this->meilleurScore; }
    public function setMeilleurScore(int $meilleurScore): self { $this->meilleurScore = $meilleurScore; return $this; }

    public function getScoreMoyen(): float { return $this->scoreMoyen; }
    public function setScoreMoyen(float $scoreMoyen): self { $this->scoreMoyen = $scoreMoyen; return $this; }
}
