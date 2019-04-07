<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class CountryController extends AbstractFOSRestController
{

    /* @var CountryRepository */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Retrieves a collection of Countries resources
     * @Route("/countries", methods={"GET"})
    */
    public function getCountries(): Response
    {
        /**
         * @todo ordering by beers no
         */
        $countries = $this->countryRepository->findAll();

        $view = $this->view($countries, Response::HTTP_OK);
        return $this->handleView($view);
    }
}
