<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Expert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Administrateur::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Administrateur $administrateur = null;

    #[ORM\ManyToMany(targetEntity: Agriculteur::class, mappedBy: 'evenements')]
    private Collection $agriculteurs;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'evenements')]
    private Collection $fournisseurs;


    #[ORM\ManyToMany(targetEntity: Expert::class, inversedBy: "evenements")]
    private Collection $experts;

    

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: "evenement")]
    private Collection $tickets;
    
    public function __construct()
    {
        $this->agriculteurs = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getAdministrateur(): ?Administrateur
    {
        return $this->administrateur;
    }

    public function setAdministrateur(?Administrateur $administrateur): static
    {
        $this->administrateur = $administrateur;
        return $this;
    }

    // Agriculteurs
    public function getAgriculteurs(): Collection
    {
        return $this->agriculteurs;
    }

    public function addAgriculteur(Agriculteur $agriculteur): static
    {
        if (!$this->agriculteurs->contains($agriculteur)) {
            $this->agriculteurs->add($agriculteur);
            $agriculteur->addEvenement($this);
        }
        return $this;
    }

    public function removeAgriculteur(Agriculteur $agriculteur): static
    {
        if ($this->agriculteurs->removeElement($agriculteur)) {
            $agriculteur->removeEvenement($this);
        }
        return $this;
    }

    // Fournisseurs
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): static
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->addEvenement($this);
        }
        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): static
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeEvenement($this);
        }
        return $this;
    }

    // Tickets
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setEvenement($this);
        }
        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            if ($ticket->getEvenement() === $this) {
                $ticket->setEvenement(null);
            }
        }
        return $this;
    }
}
