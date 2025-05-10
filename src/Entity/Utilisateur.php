<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    'agriculteur' => Agriculteur::class,
    'fournisseur' => Fournisseur::class,
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

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    // Ajout des nouvelles propriétés
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone = null;

      /**
     * @var Collection<int, Evenement>
     */
    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Evenement::class, orphanRemoval: true)]
    private Collection $evenements;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Ticket::class, orphanRemoval: true)]
    private Collection $tickets;

    public function __construct()
    {
        $this->roles = ['ROLE_USER']; // Rôle par défaut
        $this->evenements = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setUtilisateur($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getUtilisateur() === $this) {
                $ticket->setUtilisateur(null);
            }
        }

        return $this;
    }

    // Méthodes pour les nouvelles propriétés
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

    // Méthodes existantes
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
    return $this->roles; // Return ONLY explicitly assigned roles
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
    // Dans Utilisateur.php
        public function getType(): string
        {
            if (in_array('ROLE_FOURNISSEUR', $this->getRoles())) {
                return 'fournisseur';
            } elseif (in_array('ROLE_EXPERT', $this->getRoles())) {
                return 'expert';
            } elseif (in_array('ROLE_AGRICULTEUR', $this->getRoles())) {
                return 'agriculteur';
            } elseif (in_array('ROLE_ADMIN', $this->getRoles())) {
                return 'administrateur';
            }
            return 'default'; // Fallback
        }

    public function eraseCredentials(): void
    {
        // Si tu stockes des données sensibles, les effacer ici
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getUtilisateur() === $this) {
                $evenement->setUtilisateur(null);
            }
        }

        return $this;
    }
   

    #[Route('/utilisateurs/pdf', name: 'export_utilisateurs_pdf')]
    public function exportPdf(Environment $twig, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les utilisateurs depuis la base de données
        $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findAll();

        // Générer le HTML à partir du template
        $html = $twig->render('utilisateurs/pdf.html.twig', [
            'utilisateurs' => $utilisateurs
        ]);

        // Options pour Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Initialiser Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Retourner le fichier PDF en réponse
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="utilisateurs.pdf"',
        ]);
        

    }
}
