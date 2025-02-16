<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Fournisseur extends Utilisateur
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $idFiscale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorieProduit = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_FOURNISSEUR']);
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