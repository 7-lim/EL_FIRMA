<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $nomProduit = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: "integer")]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix = null; // DECIMAL should be stored as string

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "produits")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $fournisseur = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $agriculteur = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: "produits")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getFournisseur(): ?Utilisateur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Utilisateur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;
        return $this;
    }

    public function getAgriculteur(): ?Utilisateur
    {
        return $this->agriculteur;
    }

    public function setAgriculteur(?Utilisateur $agriculteur): static
    {
        $this->agriculteur = $agriculteur;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function __toString(): string
    {
        return $this->nomProduit;
    }
}
