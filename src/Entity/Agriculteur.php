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

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'agriculteur')]
    private Collection $produits;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'agriculteur')]
    private Collection $tickets;

    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $discussions;

    /**
     * Optionally stored in the database if you add a @ORM\Column for it
     */
    // #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseExploitation = null;

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

    // ──────────────────────────
    // AdresseExploitation (Optional DB)
    // ──────────────────────────

    public function setAdresseExploitation(?string $adresseExploitation): self
    {
        $this->adresseExploitation = $adresseExploitation;
        return $this;
    }

    public function getAdresseExploitation(): ?string
    {
        return $this->adresseExploitation;
    }

    // ──────────────────────────
    // Localisation
    // ──────────────────────────

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): static
    {
        $this->localisation = $localisation;
        return $this;
    }

    // ──────────────────────────
    // Evenements (ManyToMany)
    // ──────────────────────────

    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            // If you need a bidirectional link, you'd set $evenement->addAgriculteur($this) as well
        }
        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        $this->evenements->removeElement($evenement);
        // If you need to remove the bidirectional link, call $evenement->removeAgriculteur($this)
        return $this;
    }

    // ──────────────────────────
    // Produits (OneToMany)
    // ──────────────────────────

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setAgriculteur($this);
        }
        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getAgriculteur() === $this) {
                $produit->setAgriculteur(null);
            }
        }
        return $this;
    }

    // ──────────────────────────
    // Tickets (OneToMany)
    // ──────────────────────────

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setAgriculteur($this);
        }
        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            if ($ticket->getAgriculteur() === $this) {
                $ticket->setAgriculteur(null);
            }
        }
        return $this;
    }

    // ──────────────────────────
    // Discussions (OneToMany)
    // ──────────────────────────

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

    // ──────────────────────────
    // Terrains (OneToMany)
    // ──────────────────────────

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

    // ──────────────────────────
    // Reclamations (OneToMany)
    // ──────────────────────────

    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }


}
