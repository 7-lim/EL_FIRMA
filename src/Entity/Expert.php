<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
class Expert extends Utilisateur
{

    #[ORM\Column(length: 55)]
    private ?string $DomaineExpertise = null;

    /**
     * @var Collection<int, Discussion>
     */
    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'expert')]
    private Collection $discussions;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'expert')]
    private Collection $tickets;

    public function __construct()
    {
        $this->discussions = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }


    public function getDomaineExpertise(): ?string
    {
        return $this->DomaineExpertise;
    }

    public function setDomaineExpertise(string $DomaineExpertise): static
    {
        $this->DomaineExpertise = $DomaineExpertise;

        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

   
    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setExpert($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getExpert() === $this) {
                $ticket->setExpert(null);
            }
        }

        return $this;
    }
}