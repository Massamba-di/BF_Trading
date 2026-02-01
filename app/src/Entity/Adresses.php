<?php

namespace App\Entity;

use App\Repository\AdressesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressesRepository::class)]
class Adresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $adress_number = null;

    #[ORM\Column(length: 50)]
    private ?string $street = null;

    #[ORM\Column(length: 5)]
    private ?string $postal = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    private ?Users $user = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'adresses')]
    private Collection $resevation;

    public function __construct()
    {
        $this->resevation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdressNumber(): ?string
    {
        return $this->adress_number;
    }

    public function setAdressNumber(string $adress_number): static
    {
        $this->adress_number = $adress_number;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): static
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getResevation(): Collection
    {
        return $this->resevation;
    }

    public function addResevation(Reservation $resevation): static
    {
        if (!$this->resevation->contains($resevation)) {
            $this->resevation->add($resevation);
            $resevation->setAdresses($this);
        }

        return $this;
    }

    public function removeResevation(Reservation $resevation): static
    {
        if ($this->resevation->removeElement($resevation)) {
            // set the owning side to null (unless already changed)
            if ($resevation->getAdresses() === $this) {
                $resevation->setAdresses(null);
            }
        }

        return $this;
    }
}
