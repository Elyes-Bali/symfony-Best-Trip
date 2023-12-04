<?php

namespace App\Entity;
use App\Entity\Reponsereclamation; 
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use App\Repository\ReponsereclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;
 #[ORM\Entity(repositoryClass: ReponsereclamationRepository::class)]
    
   class Reponsereclamation
   {
       #[ORM\Column]
       #[Assert\NotNull(message:"Idu cannot be null.")]
       private ?int $idu = null;
   
       #[ORM\Column(length:500)]
       #[Assert\NotBlank(message:"Prenom cannot be blank.")]
        #[Assert\Length(max:500, maxMessage:"Prenom cannot be longer than {{ limit }} characters.")]
       private ?string $prenom =null;
   
         #[ORM\Column(length:500)]
         #[Assert\NotBlank(message:"Intitule cannot be blank.")]
         #[Assert\Length(max:500, maxMessage:"Intitule cannot be longer than {{ limit }} characters.")]     
       private ?string $intitule=null;
   
        #[ORM\Column(length:500)]
        #[Assert\NotBlank(message:"Textreprec cannot be blank.")]
        #[Assert\Length(max:500, maxMessage:"Textreprec cannot be longer than {{ limit }} characters.")]            
       private ?string $textreprec = null;
   
       #[ORM\Id]
       #[ORM\GeneratedValue]
       #[ORM\Column]
       private ?int $idreprec =null;
   
       #[ORM\ManyToOne(targetEntity: "Reclamation")]
#[ORM\JoinColumn(name: "idRec", referencedColumnName: "idrec")]
private ?Reclamation $idrec;
   
       public function getIdu(): ?int
       {
           return $this->idu;
       }
   
       public function setIdu(int $idu): static
       {
           $this->idu = $idu;
   
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
   
       public function getIntitule(): ?string
       {
           return $this->intitule;
       }
   
       public function setIntitule(string $intitule): static
       {
           $this->intitule = $intitule;
   
           return $this;
       }
   
       public function getTextreprec(): ?string
       {
           return $this->textreprec;
       }
   
       public function setTextreprec(string $textreprec): static
       {
           $this->textreprec = $textreprec;
   
           return $this;
       }
   
       public function getIdreprec(): ?int
       {
           return $this->idreprec;
       }
   
       public function getIdrec(): ?Reclamation
       {
           return $this->idrec;
       }
   
       public function setIdrec(?Reclamation $idrec): static
       {
           $this->idrec = $idrec;
   
           return $this;
       }
   

       public function setIdreprec(string $idreprec): static
       {
           $this->idreprec = $idreprec;

           return $this;
       }

       public function __toString(): string
       {
           return (string) $this->intitule;
           
       }
       
   }