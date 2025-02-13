<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Administrateur extends Utilisateur
{
    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_ADMIN']);
    }
}