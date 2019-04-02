<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Entity\Brewer;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class BrewerController extends AbstractFOSRestController
{
    /**
     * Retrieves a single Brewer resource
     * @param int $id
     * @Route("/brewers/{id}", methods={"GET"})
    */
    public function getBrewer(int $id): Response
    {
        $brewer = $this->getDoctrine()->getRepository(Brewer::class)->findOneBy(['id' => $id]);

        //200 HTTP OK if found else 404 NOT FOUND
        $view = $this->view($brewer, $brewer ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
        return $this->handleView($view);
    }
}