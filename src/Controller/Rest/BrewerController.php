<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Repository\BrewerRepository;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class BrewerController extends AbstractFOSRestController
{

    /* @var BrewerRepository */
    private $brewerRepository;

    public function __construct(BrewerRepository $brewerRepository)
    {
        $this->brewerRepository = $brewerRepository;
    }

    /**
     * Retrieves a single Brewer resource
     * @param int $id
     * @Route("/brewers/{id}", methods={"GET"})
    */
    public function getBrewer(int $id): Response
    {
        $brewer = $this->brewerRepository->findOneBy(['id' => $id]);

        //200 HTTP OK if found else 404 NOT FOUND
        $view = $this->view($brewer, $brewer ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
        return $this->handleView($view);
    }

    /**
     * Retrieves a collection of Brewers resources
     * @Route("/brewers", methods={"GET"})
    */
    public function getBrewers(): Response
    {
        $brewers = $this->brewerRepository->findAllOrderedByBeersNo('DESC');

        $view = $this->view(['brewers' => $brewers], Response::HTTP_OK);
        return $this->handleView($view);
    }
}
