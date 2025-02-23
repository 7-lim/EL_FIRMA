<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column]
    protected array $roles = [];

    #[ORM\Column]
    protected ?string $password = null;

    #[ORM\Column(length: 50)]
    protected ?string $nom = null;

    #[ORM\Column(length: 50)]
    protected ?string $prenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    protected ?string $telephone = null;

    #[ORM\Column(type: 'boolean')]
    protected bool $actif = true;



    /**
     *  Example: A user can have multiple Reclamations
     *  -> "mappedBy" must match the property in Reclamation (e.g. $utilisateur).
     *  -> "cascade" allows automatic persistence/removal of child entities.
     */
    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    protected Collection $reclamations;

    /**
     *  Example: A user can have multiple Evenements
     *  -> "mappedBy" must match the property in Evenement (e.g. $utilisateur).
     */
    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    protected Collection $evenements;

    /**
     *  Example: A user can have multiple Terrains
     *  -> "mappedBy" must match the property in Terrain (e.g. $utilisateur).
     */
    #[ORM\OneToMany(targetEntity: Terrain::class, mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    protected Collection $terrains;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * By default, all users will have ROLE_USER, unless overridden by child classes.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // Guarantee minimum role
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;
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
