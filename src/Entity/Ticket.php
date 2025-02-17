<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive (message:'Le prix doit être positif')]
    #[Assert\NotBlank (message:'Le prix ne doit pas être vide')]
    #[Assert\NotNull (message: 'Le prix ne doit pas être nul')]
    private ?int $Prix = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Agriculteur $agriculteur = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Expert $expert = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')] // Add referential integrity
    private ?Evenement $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getAgriculteurs(): ?Agriculteur
    {
        return $this->agriculteur;
    }

    public function setAgrivulteur(?Agriculteur $agriculteur): static
    {
        $this->agriculteur = $agriculteur;

        return $this;
    }


    public function getExpert(): ?Expert
    {
        return $this->expert;
    }

    public function setExpert(?Expert $expert): static
    {
        $this->expert = $expert;

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
