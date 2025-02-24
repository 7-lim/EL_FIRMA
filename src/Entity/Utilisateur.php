<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\InheritanceType(value: 'JOINED')]
#[ORM\DiscriminatorColumn(name: 'disc', type: 'string')]
#[ORM\DiscriminatorMap([
    'Agriculteur' => Agriculteur::class,
    'Administrateur' => Administrateur::class,
    'Fournisseur' => Fournisseur::class,
    'Expert' => Expert::class,
])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\Column(type: 'integer')]

    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $Nom = null;

    #[ORM\Column(length: 55)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 55, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $Telephone = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;



    

    public function getId(): ?int
    {
        return $this->id;

    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;

    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): static
    {
        $this->Telephone = $Telephone;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // Guarantee every user at least has ROLE_USER
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary sensitive data, clear it here
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}