<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class TypeController extends AbstractFOSRestController
{

    /* @var TypeRepository */
    private $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * Retrieves a collection of Types resources
     * @Route("/types", methods={"GET"})
    */
    public function getTypes(): Response
    {
        $types = $this->typeRepository->findAll();

        $view = $this->view($types, Response::HTTP_OK);
        return $this->handleView($view);
    }
}
