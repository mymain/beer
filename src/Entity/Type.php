<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 * @UniqueEntity("name", message="Type name is already in use.")
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Beer", mappedBy="type")
     */
    private $Beer;

    public function __construct()
    {
        $this->Beer = new ArrayCollection();
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
     * @FOS\RestBundle\Controller\Annotations\View(serializerGroups={"beer"})
     */
    public function getBeer(): Collection
    {
        return $this->Beer;
    }

    public function addBeer(Beer $beer): self
    {
        if (!$this->Beer->contains($beer)) {
            $this->Beer[] = $beer;
            $beer->setType($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): self
    {
        if ($this->Beer->contains($beer)) {
            $this->Beer->removeElement($beer);
            // set the owning side to null (unless already changed)
            if ($beer->getType() === $this) {
                $beer->setType(null);
            }
        }

        return $this;
    }
}
