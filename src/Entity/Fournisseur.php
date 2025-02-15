<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Fournisseur extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $idFiscale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorieProduit = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_FOURNISSEUR']);
        $this->evenements = new ArrayCollection();
    }

    // Getters et setters pour nomEntreprise
    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;
        return $this;
    }

    // Getters et setters pour idFiscale
    public function getIdFiscale(): ?string
    {
        return $this->idFiscale;
    }

    public function setIdFiscale(?string $idFiscale): self
    {
        $this->idFiscale = $idFiscale;
        return $this;
    }

    // Getters et setters pour categorieProduit
    public function getCategorieProduit(): ?string
    {
        return $this->categorieProduit;
    }

    public function setCategorieProduit(?string $categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;
        return $this;
    }
    private Collection $evenements;

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        $this->evenements->removeElement($evenement);

        return $this;
    }
}