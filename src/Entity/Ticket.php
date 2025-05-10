<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ORM\HasLifecycleCallbacks]
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
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')] // Add referential integrity
    private ?Evenement $evenement = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isPaid = false; // Ensure this is not repeated

    #[ORM\Column(length: 255)]
    private ?string $Titre_evenement = null; // Match database schema


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

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

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

    public function getQrCodeContent(): string
    {
        $user = $this->getUtilisateur() ?? $this->getUtilisateur();
        $userName = $user ? $user->getNom() . ' ' . $user->getPrenom() : 'Utilisateur inconnu';

        return json_encode([
            'event_name' => $this->getEvenement()->getTitre(),
            'user_name' => $userName,
            'price' => $this->getPrix(),
        ]);
    }

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;
        return $this;
    }

    public function getTitreEvenement(): ?string
    {
        return $this->Titre_evenement;
    }

    public function setTitreEvenement(string $Titre_evenement): static
    {
        $this->Titre_evenement = $Titre_evenement;
        return $this;
    }

}
