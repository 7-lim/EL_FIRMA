<?php

namespace App\Entity;

use App\Repository\AdministarteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministarteurRepository::class)]
class Administarteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $Privilege = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrivilege(): ?string
    {
        return $this->Privilege;
    }

    public function setPrivilege(string $Privilege): static
    {
        $this->Privilege = $Privilege;

        return $this;
    }
}
