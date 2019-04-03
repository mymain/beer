<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\Type;
use App\Entity\Brewer;
use App\Entity\Country;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $filtersData = [];
        foreach ([new Brewer, new Type, new Country] as $filterClass) {
            foreach ($this->getDoctrine()->getRepository(get_class($filterClass))->findAll() as $row) {
                $filtersData[(new \ReflectionClass($filterClass))->getShortName()][] = [
                    'value' => $row->getId(),
                    'label' => $row->getName()
                ];
            }
        }
        return $this->render('index.html.twig', [
            'filtersData' => $filtersData
        ]);
    }
}
