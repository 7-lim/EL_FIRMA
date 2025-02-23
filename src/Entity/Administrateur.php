<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Administrateur extends Utilisateur
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $domaineExpertise = null;

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'administrateur', cascade: ['persist', 'remove'])]
    private Collection $evenements;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'administrateur', cascade: ['persist', 'remove'])]
    private Collection $reclamations;

    public function __construct()
    {
        parent::__construct();
        $this->evenements = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->setRoles(['ROLE_ADMIN']); // Set default role
    }

    public function getDomaineExpertise(): ?string
    {
        return $this->domaineExpertise;
    }

    public function setDomaineExpertise(?string $domaineExpertise): self
    {
        $this->domaineExpertise = $domaineExpertise;
        return $this;
    }

    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setAdministrateur($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getAdministrateur() === $this) {
                $evenement->setAdministrateur(null);
            }
        }

        return $this;
    }

    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setAdministrateur($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getAdministrateur() === $this) {
                $reclamation->setAdministrateur(null);
            }
        }

        return $this;
    }
}
