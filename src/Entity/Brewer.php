<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrewerRepository")
 * @UniqueEntity("name", message="Brewer name is already in use.")
 * @JMS\ExclusionPolicy("all")
 */
class Brewer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @JMS\Expose()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Beer", mappedBy="brewer")
     */
    private $beers;

    public function __construct()
    {
        $this->beers = new ArrayCollection();
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

    /**
     * @return Collection|Beer[]
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function addBeer(Beer $beer): self
    {
        if (!$this->beers->contains($beer)) {
            $this->beers[] = $beer;
            $beer->setBrewer($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): self
    {
        if ($this->beers->contains($beer)) {
            $this->beers->removeElement($beer);
            // set the owning side to null (unless already changed)
            if ($beer->getBrewer() === $this) {
                $beer->setBrewer(null);
            }
        }

        return $this;
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getBeersNo()
    {
        return $this->beers->count();
    }
}
