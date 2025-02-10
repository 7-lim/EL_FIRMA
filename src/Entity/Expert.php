<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
class Expert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $DomaineExpertise = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
