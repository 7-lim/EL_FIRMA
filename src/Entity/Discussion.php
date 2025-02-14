<?php

namespace App\Entity;

use App\Repository\DiscussionRepository; // Ensure this class exists in the specified namespace
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionRepository::class)]
class Discussion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDiscussion = null;

    #[ORM\Column(length: 55)]
    private ?string $statutDiscussion = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    private ?Agriculteur $agriculteur = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    private ?Expert $expert = null;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'discussion')]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDiscussion(): ?\DateTimeInterface
    {
        return $this->dateDiscussion;
    }

    public function setDateDiscussion(\DateTimeInterface $dateDiscussion): static
    {
        $this->dateDiscussion = $dateDiscussion;
        return $this;
    }

    public function getStatutDiscussion(): ?string
    {
        return $this->statutDiscussion;
    }

    public function setStatutDiscussion(string $statutDiscussion): static
    {
        $this->statutDiscussion = $statutDiscussion;
        return $this;
    }

    public function getAgriculteur(): ?Agriculteur
    {
        return $this->agriculteur;
    }

    public function setAgriculteur(?Agriculteur $agriculteur): static
    {
        $this->agriculteur = $agriculteur;

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

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setDiscussion($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDiscussion() === $this) {
                $message->setDiscussion(null);
            }
        }

        return $this;
    }
}