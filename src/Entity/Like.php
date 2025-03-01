<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes', targetEntity: User::class)]
    #[ORM\JoinColumn(name: "emetteur_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?User $emetteur = null;

    #[ORM\ManyToOne(inversedBy: 'likes', targetEntity: Message::class)]
    #[ORM\JoinColumn(name: "message_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Message $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmetteur(): ?User
    {
        return $this->emetteur;
    }

    public function setEmetteur(?User $emetteur): static
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): static
    {
        $this->message = $message;

        return $this;
    }
}
