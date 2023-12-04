<?php

namespace App\Entity;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $idrec = null;

    #[ORM\Column(length:500)]
    #[Assert\NotBlank(message:"Intitule ne peut pas être vide.")]
    #[Assert\Length(max:500, maxMessage:"Intitule cannot be longer than {{ limit }} characters.")]

    private ?string $intitule = null;

    #[ORM\Column(length:500)]
    #[Assert\NotBlank(message:"Text ne peut pas être vide.")]
    #[Assert\Length(max:500, maxMessage:"Textrec cannot be longer than {{ limit }} characters.")]
    private ?string $textrec = null;

    #[ORM\Column]
    private ?int $idu = 1;

    #[ORM\Column(length:500)]
    #[Assert\NotBlank(message:"E-mail ne peut pas être vide.")]
    #[Assert\Email(message:"Invalid email format.")]
    private ?string $emailu = null;

    public function getIdrec(): ?int
    {
        return $this->idrec;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getTextrec(): ?string
    {
        return $this->textrec;
    }

    public function setTextrec(string $textrec): static
    {
        $this->textrec = $textrec;

        return $this;
    }

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function setIdu(int $idu): static
    {
        $this->idu = $idu;

        return $this;
    }

    public function getEmailu(): ?string
    {
        return $this->emailu;
    }

    public function setEmailu(string $emailu): static
    {
        $this->emailu = $emailu;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->idrec;
    }

    
}
