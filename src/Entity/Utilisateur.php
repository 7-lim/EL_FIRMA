<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: "utilisateur")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    'agriculteur' => Agriculteur::class,
    'expert' => Expert::class,
    'administrateur' => Administrateur::class,
])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
abstract class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'array')]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'boolean')]
    private bool $actif = true;

    #[ORM\OneToMany(targetEntity: Terrain::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $terrains;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $reclamations;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'fournisseur', cascade: ['persist', 'remove'])]
    private Collection $produits;

    #[ORM\OneToMany(targetEntity: Discussion::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $discussions;

    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $locations;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'agriculteur', cascade: ['persist', 'remove'])]
    private Collection $tickets;

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'administrateur', cascade: ['persist', 'remove'])]
    private Collection $evenements;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'participants')]
    private Collection $evenementsParticipant;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->terrains = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        }
    

    // Core User Management

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // No sensitive data stored
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;
        return $this;
    }

    // Relations

    public function getTerrains(): Collection
    {
        return $this->terrains;
    }

    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

   
    }
