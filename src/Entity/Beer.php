<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeerRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Beer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose()
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @JMS\Expose()
     */
    private $pricePerLiter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brewer", inversedBy="beers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brewer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="beers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="beers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Expose()
     */
    private $image;

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

    public function getPricePerLiter()
    {
        return $this->pricePerLiter;
    }

    public function setPricePerLiter($pricePerLiter): self
    {
        $this->pricePerLiter = $pricePerLiter;

        return $this;
    }

    public function getBrewer(): ?Brewer
    {
        return $this->brewer;
    }

    public function setBrewer(?Brewer $brewer): self
    {
        $this->brewer = $brewer;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getBrewerName()
    {
        return $this->brewer->getName();
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getBrewerId()
    {
        return $this->brewer->getId();
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getTypeName()
    {
        return $this->type->getName();
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getTypeId()
    {
        return $this->type->getId();
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getCountryName()
    {
        return $this->country->getName();
    }

    /**
    * @JMS\VirtualProperty
    * @JMS\Expose()
    */
    public function getCountryId()
    {
        return $this->country->getId();
    }

}
