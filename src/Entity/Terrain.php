<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $superficie = null;

    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    #[ORM\Column]
    private ?float $Latitude = null;

    #[ORM\Column]
    private ?float $Longitude = null;

    #[ORM\Column(length: 55)]
    private ?string $TypeSol = null;
    

    #[ORM\Column]
    private ?bool $IrrigationDisponible = null;

    #[ORM\Column(length: 55)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'terrains')]
    private ?Agriculteur $agriculteur = null;

    /**
     * @var Collection<int, Location>
     */
    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'terrain')]
    private Collection $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->Latitude;
    }

    public function setLatitude(float $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->Longitude;
    }

    public function setLongitude(float $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getTypeSol(): ?string
    {
        return $this->TypeSol;
    }

    public function setTypeSol(string $TypeSol): static
    {
        $this->TypeSol = $TypeSol;

        return $this;
    }

    public function isIrrigationDisponible(): ?bool
    {
        return $this->IrrigationDisponible;
    }

    public function setIrrigationDisponible(bool $IrrigationDisponible): static
    {
        $this->IrrigationDisponible = $IrrigationDisponible;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAgriculteur(): ?Agriculteur
    {
        return $this->agriculteur;
    }

    public function setAgriculteur(?Agriculteur $agriculteur): static
    {
        $this->agriculteur = $agriculteur;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setTerrain($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getTerrain() === $this) {
                $location->setTerrain(null);
            }
        }

        return $this;
    }
}