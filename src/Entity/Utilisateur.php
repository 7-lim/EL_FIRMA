<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'utilisateur')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'disc', type: 'string')]
#[ORM\DiscriminatorMap([
    'Agriculteur'    => Agriculteur::class,
    'Administrateur' => Administrateur::class,
    'Fournisseur'    => Fournisseur::class,
    'Expert'         => Expert::class,
])]
abstract class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $nom = null;

    #[ORM\Column(length: 255)]
    protected ?string $prenom = null;

    #[ORM\Column(length: 180)]
    protected ?string $email = null;

    #[ORM\Column(length: 50, nullable: true)]
    protected ?string $telephone = null;

    // Changed property to "password" to follow common convention.
    #[ORM\Column(length: 255)]
    protected ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $disc = null;

    #[ORM\Column(length: 50, nullable: true)]
    protected ?string $type = null;

    #[ORM\Column(type: Types::JSON)]
    protected array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * Returns the hashed password.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getDisc(): ?string
    {
        return $this->disc;
    }

    public function setDisc(?string $disc): self
    {
        $this->disc = $disc;
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

    public function getRoles(): array
    {
        $roles = $this->roles;
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? '';
    }

    public function eraseCredentials(): void
    {
        // Clear temporary sensitive data if needed.
    }
}
