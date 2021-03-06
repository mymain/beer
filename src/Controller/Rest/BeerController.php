<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Entity\Beer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class BeerController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of Beer resources
     * @Route("/beers", methods={"GET"})
     */
    public function getBeers(Request $request): Response
    {
        $page = $request->query->getInt('pageNumber', 1);
        $size = $request->query->getInt('pageSize', 5);
        $brewerId = $request->query->getInt('brewerId');
        $name = $request->query->get('name', null);
        $priceFrom = (float)$request->query->get('priceFrom');
        $priceTo = (float)$request->query->get('priceTo');
        $countryId = (int)$request->query->getInt('countryId');
        $typeId = (int)$request->query->getInt('typeId');
        /**
         * @todo filtering and pagination
         */
        //usefull https://medium.com/@mischenkoandrey/simple-restful-pagination-with-symfony-and-angularjs-9cb003cb38f
        $beers = $this->getDoctrine()->getRepository(Beer::class)->findAllPaginated(
            $page,
            $size,
            $brewerId,
            $name,
            $priceFrom,
            $priceTo,
            $countryId,
            $typeId
        );
        
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of beers object
        $view = $this->view([
            'beers' => $beers->getIterator(),
            'totalElements' => $beers->count(),
            'page' => $page,
            'size' => $size
        ],
            Response::HTTP_OK
        );

        //without JMSSerializerBundle
        //A circular reference has been detected when serializing the object of class
        //see https://www.cloudways.com/blog/rest-api-in-symfony-3-1/
        return $this->handleView($view);
    }

    /**
     * Retrieves a single Beer resource
     * @Route("/beers/{id}", methods={"GET"})
     */
    public function getBeer(int $id): Response
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->findOneBy(['id' => $id]);
        //200 HTTP OK if found else 404 NOT FOUND
        $view = $this->view($beer, $beer ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);

        return $this->handleView($view);
    }
}
