<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFin = null;

    #[ORM\Column]
    private ?float $PrixLocation = null;

    #[ORM\Column]
    private ?bool $PaiementEffectue = null;

    #[ORM\Column(length: 55)]
    private ?string $ModePaiement = null;

    #[ORM\Column(length: 55)]
    private ?string $Statut = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    private ?Terrain $terrain = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): static
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getPrixLocation(): ?float
    {
        return $this->PrixLocation;
    }

    public function setPrixLocation(float $PrixLocation): static
    {
        $this->PrixLocation = $PrixLocation;

        return $this;
    }

    public function isPaiementEffectue(): ?bool
    {
        return $this->PaiementEffectue;
    }

    public function setPaiementEffectue(bool $PaiementEffectue): static
    {
        $this->PaiementEffectue = $PaiementEffectue;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->ModePaiement;
    }

    public function setModePaiement(string $ModePaiement): static
    {
        $this->ModePaiement = $ModePaiement;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getTerrain(): ?Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?Terrain $terrain): static
    {
        $this->terrain = $terrain;

        return $this;
    }
}
