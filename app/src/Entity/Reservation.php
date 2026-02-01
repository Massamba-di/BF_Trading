<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column]
    private ?\DateTime $dateFin = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\ManyToOne(inversedBy: 'resevation')]
    private ?Adresses $adresses = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicules $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Users $user = null;

    // ===== getId =====
    public function getId(): ?int
    {
        return $this->id;
    }

    // ===== dateDebut =====
    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    // ===== dateFin =====
    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    // ===== total =====
    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;
        return $this;
    }

    // ===== adresses =====
    public function getAdresses(): ?Adresses
    {
        return $this->adresses;
    }

    public function setAdresses(?Adresses $adresses): static
    {
        $this->adresses = $adresses;
        return $this;
    }

    // ===== vehicule =====
    public function getVehicule(): ?Vehicules
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicules $vehicule): static
    {
        $this->vehicule = $vehicule;
        return $this;
    }

    // ===== user =====
    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;
        return $this;
    }
}
