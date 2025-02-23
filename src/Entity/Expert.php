<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ExpertRepository;

#[ORM\Entity(repositoryClass: ExpertRepository::class)]
class Expert extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Le domaine d'expertise est requis.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le domaine d'expertise ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $domaineExpertise = null;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: "experts")]
    private Collection $evenements;
    
    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: "expert")]
    private Collection $reclamations;
        /**
     * @var Collection<int, Discussion>
     */
    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'expert', cascade: ['persist', 'remove'])]
    private Collection $discussions;

    /**
     * @var Collection<int, Reclamation>
     */


    public function __construct()
    {
        parent::__construct();
        $this->evenements = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

    public function getDomaineExpertise(): ?string
    {
        return $this->domaineExpertise;
    }

    public function setDomaineExpertise(string $domaineExpertise): static
    {
        $this->domaineExpertise = $domaineExpertise;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }



    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): static
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions->add($discussion);
            $discussion->setExpert($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            if ($discussion->getExpert() === $this) {
                $discussion->setExpert(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

   

}
