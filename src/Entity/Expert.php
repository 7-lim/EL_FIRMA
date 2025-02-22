<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
class Expert extends Utilisateur
{

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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domaineExpertise = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_EXPERT']);
        $this->discussions = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }


    // Getters et setters pour domaineExpertise
    public function getDomaineExpertise(): ?string
    {
        return $this->domaineExpertise;
    }

    public function setDomaineExpertise(?string $domaineExpertise): self
    {
        $this->domaineExpertise = $domaineExpertise;
        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
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
            // set the owning side to null (unless already changed)
            if ($discussion->getExpert() === $this) {
                $discussion->setExpert(null);
            }
        }

        return $this;
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

