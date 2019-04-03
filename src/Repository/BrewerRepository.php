<?php

namespace App\Repository;

use App\Entity\Brewer;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Brewer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewer[]    findAll()
 * @method Brewer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brewer::class);
    }

    // /**
    //  * @return Brewer[] Returns an array of Brewer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findAllOrderedByBeersNo(?string $sortDirection) : array
    {
        $queryBuilder = $this->createQueryBuilder('b');
        $queryBuilder->select('COUNT(beers.id) AS HIDDEN beers_no', 'brewer');
        $queryBuilder->from(Brewer::class, 'brewer');
        $queryBuilder->leftJoin('brewer.beers', 'beers');

        if ($sortDirection) {
            $queryBuilder->orderBy('beers_no', $sortDirection);
        }
        
        //without groupping only one row is returned
        $queryBuilder->groupBy('brewer');
        return $queryBuilder->getQuery()->execute();
    }

}
