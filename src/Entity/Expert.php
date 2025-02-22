<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
class Expert extends Utilisateur
{
    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'expert', cascade: ['persist', 'remove'])]
    private Collection $discussions;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'expert', cascade: ['persist', 'remove'])]
    private Collection $tickets;

    public function __construct()
    {
        parent::__construct();
        $this->discussions = new ArrayCollection();
        $this->tickets = new ArrayCollection();
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
            $discussion->setExpert($this);
        }
        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            if ($discussion->getExpert() === $this) {
                $discussion->setExpert(null);
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
            $ticket->setExpert($this);
        }
        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            if ($ticket->getExpert() === $this) {
                $ticket->setExpert(null);
            }
        }
        return $this;
    }
}
