<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;        



#[ORM\Entity]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private ?int $prix = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private ?Utilisateur $expert = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private ?Utilisateur $agriculteur = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class)]
    private ?Evenement $evenement = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getExpert(): ?Utilisateur
    {
        return $this->expert;
    }

    public function setExpert(?Utilisateur $expert): self
    {
        $this->expert = $expert;

        return $this;
    }

    public function getAgriculteur(): ?Utilisateur
    {
        return $this->agriculteur;
    }

    public function setAgriculteur(?Utilisateur $agriculteur): self
    {
        $this->agriculteur = $agriculteur;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
    

    
}