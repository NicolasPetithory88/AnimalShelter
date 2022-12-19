<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RacesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RacesRepository::class)]
class Races
{
    use SlugTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: 'integer')]
    private ?int $racesOrder = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'races')]
    #[ORM\JoinColumn(onDelete : 'CASCADE')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $races;

    #[ORM\OneToMany(mappedBy: 'races', targetEntity: Animals::class)]
    private Collection $animals;

    public function __construct()
    {
        $this->races = new ArrayCollection();
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getRacesOrder(): ?int
    {
        return $this->racesOrder;
    }

    public function setRacesOrder(int $racesOrder): self
    {
        $this->racesOrder = $racesOrder;

        return $this;
    }


    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(self $race): self
    {
        if (!$this->races->contains($race)) {
            $this->races->add($race);
            $race->setParent($this);
        }

        return $this;
    }

    public function removeRace(self $race): self
    {
        if ($this->races->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getParent() === $this) {
                $race->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animals $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setRaces($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getRaces() === $this) {
                $animal->setRaces(null);
            }
        }

        return $this;
    }
}
