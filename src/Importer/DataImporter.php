<?php

declare(strict_types=1);

namespace App\Importer;

use App\Importer\BeerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class DataImporter
{
    /* @var EntityManagerInterface */
    private $entityManager;

    /* @var \GuzzleHttp\Client */
    private $client;

    /* @var BeerBuilder */
    private $beerBuilder;
    
    private $output = null;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->client = new \GuzzleHttp\Client;
        $this->beerBuilder = new BeerBuilder($entityManager);
    }

    public function setOutput($output): void
    {
        $this->output = $output;
    }

    public function writeln(string $text): bool
    {
        if (!$this->output) {
            return false;
        }
        
        $this->output->writeln($text, $this->output->getVerbosity());
        
        return true;
    }

    public function import(string $url): bool
    {
        try {
            $this->writeln('Getting data from remote API...');
            $response = $this->client->request('GET', $url);
            $this->writeln('Got data lets pare it!');
        } catch (\Exception $e) {
            $this->writeln($e->getMessage());
            $this->writeln('Import failed.');

            return false;
        }

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $encoder = new JsonDecode;
            $data = $encoder->decode($response->getBody(), JsonEncoder::FORMAT);//throw error
            $this->writeln('Import is in progress we will let you know about any errors or success!');
            foreach ($data as $key => $row) {
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
        } else {
            $this->writeln('Remote response code is not 200.');

            return false;
        }
        
        return true;
    }
}
