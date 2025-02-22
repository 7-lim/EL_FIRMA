<?php

namespace App\Entity;

use App\Repository\AgriculteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgriculteurRepository::class)]
class Agriculteur extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localisation = null;

    #[ORM\ManyToMany(targetEntity: Evenement::class, inversedBy: 'agriculteurs')]
    private Collection $evenements;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $produits;

    #[ORM\ManyToMany(targetEntity: Ticket::class, mappedBy: 'agriculteurs')]
    private Collection $tickets;

    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $discussions;
    private $adresseExploitation;


    #[ORM\OneToMany(targetEntity: Terrain::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $terrains;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $reclamations;

    public function __construct()
    {
        parent::__construct();
        $this->evenements = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->terrains = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }



    public function setAdresseExploitation($adresseExploitation): self
    {
        $this->adresseExploitation = $adresseExploitation;
        return $this;
    }

    public function getAdresseExploitation()
    {
        return $this->adresseExploitation;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): static
    {
        $this->localisation = $localisation;
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

    // Produits
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setAgriculteur($this);
        }
        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getAgriculteur() === $this) {
                $produit->setAgriculteur(null);
            }
        }
        return $this;
    }

    // Tickets
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
        }
        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        $this->tickets->removeElement($ticket);
        return $this;
    }

    // Discussions
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): static
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions->add($discussion);
            $discussion->setAgriculteur($this);
        }
        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            if ($discussion->getAgriculteur() === $this) {
                $discussion->setAgriculteur(null);
            }
        }
        return $this;
    }

    // Terrains
    public function getTerrains(): Collection
    {
        return $this->terrains;
    }

    public function addTerrain(Terrain $terrain): static
    {
        if (!$this->terrains->contains($terrain)) {
            $this->terrains->add($terrain);
            $terrain->setAgriculteur($this);
        }
        return $this;
    }

    public function removeTerrain(Terrain $terrain): static
    {
        if ($this->terrains->removeElement($terrain)) {
            if ($terrain->getAgriculteur() === $this) {
                $terrain->setAgriculteur(null);
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
            $reclamation->setAgriculteur($this);
        }
        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getAgriculteur() === $this) {
                $reclamation->setAgriculteur(null);
            }
        }
        return $this;
    }
}
