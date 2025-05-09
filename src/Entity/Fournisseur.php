<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur extends Utilisateur
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $idFiscale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorieProduit = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'Fournisseur', orphanRemoval: true)]
    private Collection $produits;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_FOURNISSEUR']);
        $this->produits = new ArrayCollection();
    }
    // Getters et setters pour nomEntreprise

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nom_entreprise): self
    {
        $this->nomEntreprise = $nom_entreprise;
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
}
