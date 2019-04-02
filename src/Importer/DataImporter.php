<?php

declare(strict_types=1);

namespace App\Importer;

use App\Entity\Type;

use App\Importer\BeerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class DataImporter
{
    private $entityManager;
    private $client;
    private $beerBuilder;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->client = new \GuzzleHttp\Client;
        $this->beerBuilder = new BeerBuilder($entityManager);
    }
    
    public function import(string $url): bool
    {
        
        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            return false;
        }

        if($response->getStatusCode() === Response::HTTP_OK) {
            
            $encoder = new JsonDecode;
            $data = $encoder->decode($response->getBody(), JsonEncoder::FORMAT);
            
            foreach($data as $key => $row) {
                
                $this->beerBuilder->createBeer();
                $this->beerBuilder->addType($row->type);
                $this->beerBuilder->addCountry($row->country);
                $this->beerBuilder->addBrewer($row->brewer);
                $this->beerBuilder->setPricePerLiter($row->size, (float)$row->price);

                $beer = $this->beerBuilder->getBeer();
                $beer->setName($row->name);
                $beer->setImage($row->image_url);

                $this->entityManager->persist($beer);
            }
            $this->entityManager->flush();
        }
        
        return true;
    }
}