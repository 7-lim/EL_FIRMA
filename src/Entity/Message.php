<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnvoie = null;

    #[ORM\Column(type: Types::OBJECT)]
    private ?object $FichierJoint = null;

    #[ORM\Column]
    private ?bool $Lu = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Discussion $discussion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): static
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->DateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $DateEnvoie): static
    {
        $this->DateEnvoie = $DateEnvoie;

        return $this;
    }

    public function getFichierJoint(): ?object
    {
        return $this->FichierJoint;
    }

    public function setFichierJoint(object $FichierJoint): static
    {
        $this->FichierJoint = $FichierJoint;

        return $this;
    }

    public function isLu(): ?bool
    {
        return $this->Lu;
    }

    public function setLu(bool $Lu): static
    {
        $this->Lu = $Lu;

        return $this;
    }

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): static
    {
        $this->discussion = $discussion;

        return $this;
    }
}