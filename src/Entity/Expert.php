<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[ORM\Entity]
class Expert extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domaineExpertise = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles(['ROLE_EXPERT']);
    }
   

    // Getters et setters pour domaineExpertise
    public function getDomaineExpertise(): ?string
    {
        return $this->domaineExpertise;
    }

    public function setDomaineExpertise(?string $domaineExpertise): self
    {
        $this->domaineExpertise = $domaineExpertise;
        return $this;
    }



}