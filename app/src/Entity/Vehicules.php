<?php

namespace App\Entity;

use App\Repository\VehiculesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: VehiculesRepository::class)]
class Vehicules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column(length: 50)]
    private ?string $nom = null;




    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prixJour = null;

    #[ORM\Column(length: 50)]
    private ?bool $disponible = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?Users $users = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'vehicules')]
    private Collection $reservations;

    #[ORM\Column(length: 255)]
    private ?string $images = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    private ?Categories $categories = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
    #[ORM\Column(length: 100)]
    private ?string $marque = null;

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getPrixJour(): ?string
    {
        return $this->prixJour;
    }

    public function setPrixJour(string $prixJour): static
    {
        $this->prixJour = $prixJour;

        return $this;
    }


    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setVehicules($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVehicules() === $this) {
                $reservation->setVehicules(null);
            }
        }

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): static
    {
        $this->categories = $categories;

        return $this;
    }
}
