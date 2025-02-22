<?php

namespace App\Entity;

use App\Repository\FournisseurRepository; // Ensure this class exists in the specified namespace
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entreprise = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'fournisseur', cascade: ['persist', 'remove'])]
    private Collection $produits;

    #[ORM\ManyToMany(targetEntity: Evenement::class, inversedBy: 'fournisseurs')]
    private Collection $evenements;
    private $nomEntreprise;

    private $idFiscale;

    public function getIdFiscale(): ?string
    {       
        return $this->idFiscale;
            


       }

       private $categorieProduit;

    // existing properties and methods

    public function setCategorieProduit($categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;
        return $this;
    }

    public function getCategorieProduit(): ?string
    {
        return $this->categorieProduit; 
    }
        
    

        public function setIdFiscale(string $idFiscale): self
    {
        $this->idFiscale = $idFiscale;
        return $this;
    }

    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;
        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }


    public function __construct()
    {
        parent::__construct();
        $this->produits = new ArrayCollection();
        $this->evenements = new ArrayCollection();
    }

    // Entreprise
    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(?string $entreprise): static
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    // Produits
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setFournisseur($this);
        }
        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getFournisseur() === $this) {
                $produit->setFournisseur(null);
            }
        }
        return $this;
    }

    // Evenements
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

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
