<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class Administrateur extends Utilisateur
{
    public function __construct()
    {
        parent::__construct();
        // Optionally override or ensure admin
        $this->setRoles(['ROLE_ADMIN']);
    }

    public function getRoles(): array
    {
        // Force admin role
        $roles = parent::getRoles();
        if (!in_array('ROLE_ADMIN', $roles, true)) {
            $roles[] = 'ROLE_ADMIN';
        }
        return array_unique($roles);
    }
}