<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Prix = null;

    /**
     * @var Collection<int, Agriculteur>
     */
    #[ORM\ManyToMany(targetEntity: Agriculteur::class, mappedBy: 'tickets')]
    private Collection $agriculteurs;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Expert $expert = null;

    public function __construct()
    {
        $this->agriculteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }

    /**
     * @return Collection<int, Agriculteur>
     */
    public function getAgriculteurs(): Collection
    {
        return $this->agriculteurs;
    }

    public function addDiscussion(Agriculteur $agriculteur): static
    {
        if (!$this->agriculteurs->contains($agriculteur)) {
            $this->agriculteurs->add($agriculteur);
            $agriculteur->addTicket($this);
        }

        return $this;
    }

    public function removeDiscussion(Agriculteur $agriculteur): static
    {
        if ($this->agriculteurs->removeElement($agriculteur)) {
            $agriculteur->removeTicket($this);
        }

        return $this;
    }

    public function getExpert(): ?Expert
    {
        return $this->expert;
    }

    public function setExpert(?Expert $expert): static
    {
        $this->expert = $expert;

        return $this;
    }
}
