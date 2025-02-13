<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Agriculteur extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseExploitation = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_AGRICULTEUR']); // Utilisez le setter
    }

    // Getters et setters pour adresseExploitation
    public function getAdresseExploitation(): ?string
    {
        return $this->adresseExploitation;
    }

    public function setAdresseExploitation(?string $adresseExploitation): self
    {
        $this->adresseExploitation = $adresseExploitation;
        return $this;
    }
}