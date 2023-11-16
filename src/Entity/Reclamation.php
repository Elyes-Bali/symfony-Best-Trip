<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\ReclamationRepository;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $idrec = null;

    #[ORM\Column]
    private ?string $intitule = null;

    #[ORM\Column]
    private ?string $textrec = null;

    #[ORM\Column]
    private ?int $idu = null;

    #[ORM\Column]
    private ?string $emailu = null;

    public function getIdrec(): ?int
    {
        return $this->idrec;
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

    public function getTextrec(): ?string
    {
        return $this->textrec;
    }

    public function setTextrec(?string $textrec): static
    {
        // Vérifier si le texte de la réclamation n'est pas vide
        if (empty($textrec)) {
            throw new \InvalidArgumentException("Le texte de la réclamation ne peut pas être vide.");
        }

        $this->textrec = $textrec;

        return $this;
    }

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

    public function getEmailu(): ?string
    {
        return $this->emailu;
    }

    public function setEmailu(?string $emailu): static
    {
        // Vérifier si l'email de l'utilisateur n'est pas vide
        if (empty($emailu)) {
            throw new \InvalidArgumentException("L'email de l'utilisateur ne peut pas être vide.");
        }

        $this->emailu = $emailu;

        return $this;
    }
}
