<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur extends Utilisateur
{
    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'administrateur', cascade: ['persist', 'remove'])]
    private Collection $evenements;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'administrateur', cascade: ['persist', 'remove'])]
    private Collection $reclamations;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
private ?string $domaineExpertise = null;

public function getDomaineExpertise(): ?string
{
    return $this->domaineExpertise;
}

public function setDomaineExpertise(?string $domaineExpertise): self
{
    $this->domaineExpertise = $domaineExpertise;
    return $this;
}


    public function __construct()
    {
        parent::__construct();
        $this->evenements = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
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
            $evenement->setAdministrateur($this);
        }
        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getAdministrateur() === $this) {
                $evenement->setAdministrateur(null);
            }
        }
        return $this;
    }

    // Reclamations
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setAdministrateur($this);
        }
        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getAdministrateur() === $this) {
                $reclamation->setAdministrateur(null);
            }
        }
        return $this;
    }
    
    
    


}