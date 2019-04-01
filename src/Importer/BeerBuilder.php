<?php

declare(strict_types=1);

namespace App\Importer;

use App\Entity\Beer;
use App\Entity\Type;
use App\Entity\Brewer;
use App\Entity\Country;

use Doctrine\ORM\EntityManagerInterface;

class BeerBuilder implements BeerBuilderInterface
{
    /**
     * @var Entity\Beer
     */
    private $beer;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createBeer() : Beer
    {
        return $this->beer = new Beer;
    }

    public function addType(string $name) : Beer
    {
        $type = $this->entityManager->getRepository('App\Entity\Type')->findOneBy(['name' => $name]);
        
        if(!$type) {
            $type = new Type;
            $type->setName($name);
            $this->entityManager->persist($type);
            $this->entityManager->flush();
        }

        return $this->beer->setType($type);

    }

    public function addCountry(string $name) : Beer
    {
        $country = $this->entityManager->getRepository('App\Entity\Country')->findOneBy(['name' => $name]);

        if(!$country) {
            $country = new Country;
            $country->setName($name);
            $this->entityManager->persist($country);
            $this->entityManager->flush();
        }

        return $this->beer->setCountry($country);
    }

    public function addBrewer(string $name) : Beer
    {
        $brewer = $this->entityManager->getRepository('App\Entity\Brewer')->findOneBy(['name' => $name]);

        if(!$brewer) {
            $brewer = new Brewer;
            $brewer->setName($name);
            $this->entityManager->persist($brewer);
            $this->entityManager->flush();
        }

        return $this->beer->setBrewer($brewer);
    }

    public function setPricePerLiter(string $size, float $price) : Beer
    {
        /**
         * 12  \u00d7  Can 355\u00a0ml
         * Array
            (
                [0] => 12
                [1] =>
                [2] => ×
                [3] =>
                [4] => Can
                [5] => 355
                [6] => ml
            )
         */
        $parts = preg_split('/\xA0|\x20/', $size);
        
        $count = floatval($parts[0]);//bottles/cans
        
        $sizeInLiters = $count * floatval($parts[5]) / 1000;//ml
        $pricePerLiter = $price / $sizeInLiters;
        echo 'parts: ' . $parts[0] . ' ' . $parts[5] . ' ' . $sizeInLiters . ' ' . $pricePerLiter . PHP_EOL;
        return $this->beer->setPricePerLiter($pricePerLiter);
    }

    public function getBeer(): Beer
    {
        return $this->beer;
    }
}