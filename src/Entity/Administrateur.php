<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur extends Utilisateur
{   
    #[ORM\Column(type: "boolean")]
    private ?bool $actif = true;


    /**
     * @var Collection<int, Reclamation>
     */
    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'administrateur')]
    private Collection $reclamations;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_ADMIN']);
        $this->evenements = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        parent::__construct();
        $this->setRoles(['ROLE_ADMIN']);
    }
    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;
        return $this;
    }



    /**
     * @return Collection<int, Reclamation>
     */
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
            // set the owning side to null (unless already changed)
            if ($reclamation->getAdministrateur() === $this) {
                $reclamation->setAdministrateur(null);
            }
        }

        return $this;
    }
}
