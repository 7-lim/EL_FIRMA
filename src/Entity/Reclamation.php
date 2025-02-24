<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Objet = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateSoumission = null;

    #[ORM\Column(length: 55)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateTraitement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ReponseAdmin = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?Agriculteur $agriculteur = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?Administrateur $administrateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->Objet;
    }

    public function setObjet(string $Objet): static
    {
        $this->Objet = $Objet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->DateSoumission;
    }

    public function setDateSoumission(\DateTimeInterface $DateSoumission): static
    {
        $this->DateSoumission = $DateSoumission;

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
        return $this->DateTraitement;
    }

    public function setDateTraitement(?\DateTimeInterface $DateTraitement): static
    {
        $this->DateTraitement = $DateTraitement;

        return $this;
    }

    public function getReponseAdmin(): ?string
    {
        return $this->ReponseAdmin;
    }

    public function setReponseAdmin(?string $ReponseAdmin): static
    {
        $this->ReponseAdmin = $ReponseAdmin;

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
}