<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $NomEntreprise = null;

    #[ORM\Column(length: 55)]
    private ?string $Id_fiscale = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->NomEntreprise;
    }

    public function setNomEntreprise(string $NomEntreprise): static
    {
        $this->NomEntreprise = $NomEntreprise;

        return $this;
    }

    public function getIdFiscale(): ?string
    {
        return $this->Id_fiscale;
    }

    public function setIdFiscale(string $Id_fiscale): static
    {
        $this->Id_fiscale = $Id_fiscale;

        return $this;
    }
}
