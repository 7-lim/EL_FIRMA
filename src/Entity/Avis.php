<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private string $commentaire;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    #[Assert\Range(min: 1, max: 5)]
    private int $note;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Utilisateur $locataire;

    #[ORM\ManyToOne(targetEntity: Terrain::class, inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Terrain $terrain;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getLocataire(): Utilisateur
    {
        return $this->locataire;
    }

    public function setLocataire(Utilisateur $locataire): self
    {
        $this->locataire = $locataire;
        return $this;
    }

    public function getTerrain(): Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(Terrain $terrain): self
    {
        $this->terrain = $terrain;
        return $this;
    }

    public function __toString(): string
    {
        return "Avis de {$this->locataire->getNom()} sur {$this->terrain->getLocalisation()} ({$this->note}/5)";
    }
}
