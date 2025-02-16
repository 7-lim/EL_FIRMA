<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date de début est obligatoire.")]
    #[Assert\Date(message: "La date de début doit être une date valide.")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "La date de fin est obligatoire.")]
    #[Assert\Date(message: "La date de fin doit être une date valide.")]
    #[Assert\GreaterThan(propertyPath: "dateDebut", message: "La date de fin doit être postérieure à la date de début.")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le prix de location est obligatoire.")]
    #[Assert\Positive(message: "Le prix de location doit être un nombre positif.")]
    private ?float $prixLocation = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le statut du paiement est obligatoire.")]
    private ?bool $paiementEffectue = null;

    #[ORM\Column(length: 55)]
    #[Assert\NotBlank(message: "Le mode de paiement est obligatoire.")]
    #[Assert\Length(
        max: 55,
        maxMessage: "Le mode de paiement ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $modePaiement = null;

    #[ORM\Column(length: 55)]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    #[Assert\Length(
        max: 55,
        maxMessage: "Le statut ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $statut = null;

    #[ORM\ManyToOne(targetEntity: Terrain::class, inversedBy: 'locations')]
    #[Assert\NotNull(message: "La sélection d'un terrain est obligatoire.")]
    private ?Terrain $terrain = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getPrixLocation(): ?float
    {
        return $this->prixLocation;
    }

    public function setPrixLocation(float $prixLocation): self
    {
        $this->prixLocation = $prixLocation;
        return $this;
    }

    public function isPaiementEffectue(): ?bool
    {
        return $this->paiementEffectue;
    }

    public function setPaiementEffectue(bool $paiementEffectue): self
    {
        $this->paiementEffectue = $paiementEffectue;
        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getTerrain(): ?Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?Terrain $terrain): self
    {
        $this->terrain = $terrain;
        return $this;
    }
}
