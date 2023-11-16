<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;


 #[ORM\Entity(repositoryClass: UserRepository::class)]
 
class User
{
     #[ORM\Column]
     #[ORM\Id]
     #[ORM\GeneratedValue]
    
     
    private ?int $idu = null ;

    
     #[ORM\Column(length: 20)]
     #[Assert\NotBlank(message: 'Le nom ne peut pas être vide')]
    #[Assert\Length(
        max: 20,
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères')]
     
    private ?string $nom = null ;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le prénom ne peut pas être vide')]
    #[Assert\Length(
        max: 20,
        maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères')]
    private  ?string $prenom  = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'L\'email ne peut pas être vide')]
    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas valide')]
    private ?string $email  = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le numéro de téléphone ne peut pas être vide')]
    #[Assert\Type(
        type: 'integer',
        message: 'Le numéro de téléphone doit être un nombre entier')]
    private ?int $tel = null ;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'Le mot de passe ne peut pas être vide')]
    #[Assert\Length(
        min: 8,minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères',
        max: 500, maxMessage: 'Le mot de passe ne peut pas dépasser {{ limit }} caractères')]
    private  ?string $mdp = null;

    #[ORM\Column(length: 50)]
  
    private  ?string $gender = null;

    #[ORM\Column(length: 50)]
    private  ?string $role = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'L\'âge ne peut pas être vide')]
    #[Assert\LessThanOrEqual(
        value: 'today',
        message: 'La date de naissance ne peut pas être dans le futur')]
    private ?\DateTime $age =null;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getAge(): ?\DateTime
    {
        return $this->age;
    }

    public function setAge(\DateTime $age): static
    {
        $this->age = $age;

        return $this;
    }


}
