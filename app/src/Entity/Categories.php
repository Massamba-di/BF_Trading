<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Vehicules>
     */
    #[ORM\OneToMany(targetEntity: Vehicules::class, mappedBy: 'categories')]
    private Collection $vehicules;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Vehicules>
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicules $vehicule): static
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules->add($vehicule);
            $vehicule->setCategories($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicules $vehicule): static
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getCategories() === $this) {
                $vehicule->setCategories(null);
            }
        }

        return $this;
    }
}
