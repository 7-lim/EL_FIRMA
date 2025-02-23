<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Expert;
use App\Entity\Agriculteur;
use App\Entity\Administrateur;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $objet = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSoumission = null;

    #[ORM\Column(length: 55)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateTraitement = null;

    #[ORM\ManyToOne(targetEntity: Expert::class, inversedBy: "reclamations")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Expert $expert = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reponseAdmin = null;

    #[ORM\ManyToOne(targetEntity: Agriculteur::class, inversedBy: "reclamations")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Agriculteur $agriculteur = null;

    #[ORM\ManyToOne(targetEntity: Administrateur::class, inversedBy: "reclamations")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Administrateur $administrateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(\DateTimeInterface $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;
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

    public function getDateTraitement(): ?\DateTimeInterface
    {
        return $this->dateTraitement;
    }

    public function setDateTraitement(?\DateTimeInterface $dateTraitement): static
    {
        $this->dateTraitement = $dateTraitement;
        return $this;
    }

    public function getReponseAdmin(): ?string
    {
        return $this->reponseAdmin;
    }

    public function setReponseAdmin(?string $reponseAdmin): static
    {
        $this->reponseAdmin = $reponseAdmin;
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

    public function getAdministrateur(): ?Administrateur
    {
        return $this->administrateur;
    }

    public function setAdministrateur(?Administrateur $administrateur): static
    {
        $this->administrateur = $administrateur;
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
}
