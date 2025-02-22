<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur extends Utilisateur
{
    // No need to redeclare $evenements or $reclamations since they are inherited

    // Methods to interact with Evenements (inherited from Utilisateur)
    public function getEvenements(): Collection
    {
        return parent::getEvenements();
    }


    // Methods to interact with Reclamations (inherited from Utilisateur)
    public function getReclamations(): Collection
    {
        return parent::getReclamations();
    }

    
}

