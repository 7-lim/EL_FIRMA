<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Id_ticket = null;

    #[ORM\Column]
    private ?int $Prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTicket(): ?int
    {
        return $this->Id_ticket;
    }

    public function setIdTicket(int $Id_ticket): static
    {
        $this->Id_ticket = $Id_ticket;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }
}
