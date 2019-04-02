<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Entity\Beer;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class BeerController extends AbstractFOSRestController
{
    /**
     * Display a collection of Beer resource
     * @Route("/beers", methods={"GET"})
    */
    public function getBeers(): Response
    {
        $beers = $this->getDoctrine()->getRepository(Beer::class)->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of beer object
        $view = $this->view($beers, Response::HTTP_OK);

        //without JMSSerializerBundle
        //A circular reference has been detected when serializing the object of class
        //see https://www.cloudways.com/blog/rest-api-in-symfony-3-1/
        return $this->handleView($view);
    }
}