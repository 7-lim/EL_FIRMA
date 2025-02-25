<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type("float")]
    #[Assert\Range(min: 0, max: 10000)]  // Optionnel, par exemple, pour la superficie
    private ?float $superficie = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $localisation = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type("float")]
    #[Assert\Range(min: -90, max: 90)] // Latitude doit être entre -90 et 90
    private ?float $latitude = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type("float")]
    #[Assert\Range(min: -180, max: 180)] // Longitude doit être entre -180 et 180
    private ?float $longitude = null;

    #[ORM\Column(length: 55)]
    #[Assert\NotBlank]
    private ?string $typeSol = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?bool $irrigationDisponible = null;

    #[ORM\Column(length: 55)]
    #[Assert\NotBlank]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'terrains')]
    private ?Agriculteur $agriculteur = null;

        // Ajout de la propriété photo
    #[ORM\Column(length: 255, nullable: true)]
        private ?string $photo = null;
    
        // Getter and Setter
        public function getPhoto(): ?string
        {
            return $this->photo;
        }   
        public function setPhoto(?string $photo): self
        {
            $this->photo = $photo;
            return $this;
        }    


    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'utilisateur_id', referencedColumnName: 'id')]
    private ?Utilisateur $utilisateur = null;

    // Getter and Setter
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }



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
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getTypeSol(): ?string
    {
        return $this->typeSol;
    }

    public function setTypeSol(string $typeSol): static
    {
        $this->typeSol = $typeSol;

        return $this;
    }

    public function isIrrigationDisponible(): ?bool
    {
        return $this->irrigationDisponible;
    }

    public function setIrrigationDisponible(bool $irrigationDisponible): static
    {
        $this->irrigationDisponible = $irrigationDisponible;

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
