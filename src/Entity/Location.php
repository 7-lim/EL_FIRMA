<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ORM\Table(name: 'location')]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    
    #[ORM\ManyToOne(targetEntity: Terrain::class, inversedBy: 'locations')]
    #[ORM\JoinColumn(name: 'terrain_id', referencedColumnName: 'id', nullable: false)]
    private ?Terrain $terrain = null;
    

    #[ORM\Column(name: 'date_debut', type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de début est obligatoire.")]
    #[Assert\Type(type: "\DateTimeInterface", message: "La date de début doit être une date valide.")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(name: 'date_fin', type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de fin est obligatoire.")]
    #[Assert\Type(type: "\DateTimeInterface", message: "La date de fin doit être une date valide.")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(name: 'prix_location', type: Types::FLOAT)]
    #[Assert\NotBlank(message: "Le prix de location est obligatoire.")]
    #[Assert\Type(type: "numeric", message: "Le prix doit être un nombre.")]
    #[Assert\Positive(message: "Le prix doit être positif.")]
    private ?float $prixLocation = null;

    #[ORM\Column(name: 'paiement_effectue', type: Types::BOOLEAN)]
    private bool $paiementEffectue = false;

    #[ORM\Column(name: 'mode_paiement', type: Types::STRING, length: 255, nullable: true)]
    // Optionnel : si fourni, on peut vérifier qu'il n'est pas vide.
        private ?string $modePaiement = null;

    #[ORM\Column(name: 'statut', type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    private ?string $statut = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
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

    public function isPaiementEffectue(): bool
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

    public function setModePaiement(?string $modePaiement): self
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
}