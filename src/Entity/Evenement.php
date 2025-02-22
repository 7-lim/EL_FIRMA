<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"Le titre ne doit pas étre vide")]    
    #[Assert\NotNull (message:"Le titre est obligatoire")]
    private ?string $titre;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message:"La description ne doit pas étre vide")]
    #[Assert\NotNull (message:"La description est obligatoire")]
    private ?string $description;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull (message:"La date de début est obligatoire")]
    private ?\DateTimeInterface $dateDebut;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull (message:"La date de fin est obligatoire")]
    #[Assert\GreaterThan(propertyPath: "dateDebut", message: "La date de fin doit être supérieure à la date de début")]
    private ?\DateTimeInterface $dateFin;

    #[ORM\Column(length: 55)]
    #[Assert\NotBlank (message:"Le lieu de l'évènement ene doit pas étre vide")]
    #[Assert\NotNull (message:"Le lieu de l'évènement est obligatoire")]
    private ?string $lieu;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotNull (message:"Le nombre de places est obligatoire")]
    #[Assert\Positive (message:"Le nombre de places doit être positif")]
    private ?int $nombreDePlaces = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotNull (message:"Le prix est obligatoire")]
    #[Assert\Positive (message:"Le prix doit être positif")]
    private ?int $prix = null;

    #[ORM\ManyToOne(inversedBy: 'Evenements')]
    private ?Fournisseur $fournisseurs = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    private ?Administrateur $administrateur = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: Ticket::class, orphanRemoval: true)]
    private Collection $tickets;

    public function __construct()
    {
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

    public function setTitre(?string $titre): static
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

    public function setDateDebut(?\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
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

    public function getNombreDePlaces(): ?int
    {
        return $this->nombreDePlaces;
    }

    public function setNombreDePlaces(?int $nombreDePlaces): static
    {
        $this->nombreDePlaces = $nombreDePlaces;
        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getFournisseurs(): ?Fournisseur
    {
        return $this->fournisseurs;
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

    /**
     * @return Collection<int, Ticket>
     */
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
            // set the owning side to null (unless already changed)
            if ($ticket->getEvenement() === $this) {
                $ticket->setEvenement(null);
            }
        }

        return $this;
    }
}
