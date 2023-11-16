<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponsereclamationRepository;

#[ORM\Entity(repositoryClass: ReponsereclamationRepository::class)]
class Reponsereclamation
{
    #[ORM\Column]
    private ?int $idu = null;

    #[ORM\Column]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?string $intitule = null;

    #[ORM\Column]
    private ?string $textreprec = null;

    #[ORM\Column]
    private ?int $idrec = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idreprec = null;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(?int $idu): static
    {
        // Vérifier si l'ID utilisateur n'est pas vide
        if ($idu === null) {
            throw new \InvalidArgumentException("L'ID utilisateur ne peut pas être vide.");
        }

        $this->idu = $idu;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        // Vérifier si le prénom n'est pas vide
        if (empty($prenom)) {
            throw new \InvalidArgumentException("Le prénom ne peut pas être vide.");
        }

        $this->prenom = $prenom;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): static
    {
        // Vérifier si l'intitulé n'est pas vide
        if (empty($intitule)) {
            throw new \InvalidArgumentException("L'intitulé ne peut pas être vide.");
        }

        $this->intitule = $intitule;

        return $this;
    }

    public function getTextreprec(): ?string
    {
        return $this->textreprec;
    }

    public function setTextreprec(?string $textreprec): static
    {
        // Vérifier si le texte de la réponse à la réclamation n'est pas vide
        if (empty($textreprec)) {
            throw new \InvalidArgumentException("Le texte de la réponse à la réclamation ne peut pas être vide.");
        }

        $this->textreprec = $textreprec;

        return $this;
    }

    public function getIdrec(): ?int
    {
        return $this->idrec;
    }

    public function setIdrec(?int $idrec): static
    {
        // Vérifier si l'ID de la réclamation n'est pas vide
        if ($idrec === null) {
            throw new \InvalidArgumentException("L'ID de la réclamation ne peut pas être vide.");
        }

        $this->idrec = $idrec;

        return $this;
    }

    public function getIdreprec(): ?int
    {
        return $this->idreprec;
    }
}
