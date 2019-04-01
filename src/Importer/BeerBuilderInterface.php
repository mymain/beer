<?php

namespace App\Importer;

use App\Entity\Beer;

interface BeerBuilderInterface
{
    public function createBeer();
    public function addType(string $name);
    public function addCountry(string $name);
    public function addBrewer(string $name);
    public function setPricePerLiter(string $size, float $price);
    public function getBeer(): Beer;
}