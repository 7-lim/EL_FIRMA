<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur extends Utilisateur
{
    #[ORM\Column(length: 55)]
    private ?string $NomEntreprise = null;

    #[ORM\Column(length: 55)]
    private ?string $Id_fiscale = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'fournisseur', orphanRemoval: true)]
    private Collection $produits;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\ManyToMany(targetEntity: Evenement::class, inversedBy: 'fournisseurs')]
    private Collection $Evenements;

    private $categorieProduit;

    // Add your properties and methods here

    public function setCategorieProduit($categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }

    public function getCategorieProduit()
    {
        return $this->categorieProduit;
    }


    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->Evenements = new ArrayCollection();
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

    /**
     * @return Collection<int, Produit>
     */
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
            // set the owning side to null (unless already changed)
            if ($produit->getFournisseur() === $this) {
                $produit->setFournisseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->Evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->Evenements->contains($evenement)) {
            $this->Evenements->add($evenement);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        $this->Evenements->removeElement($evenement);

        return $this;
    }
}