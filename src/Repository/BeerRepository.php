<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Beer::class);
    }

   /**
    *
    * 1. Create & pass query to paginate method
    * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
    * 3. Return that object to the controller
    *
    * @param integer $page The current page (passed from controller)
    * @param integer $size Number of elements on page (passed from controller)
    *
    * @return \Doctrine\ORM\Tools\Pagination\Paginator
    */
    public function getPaginated(int $page = 1, int $size = 5)
    {
       // Create our query
       $query = $this->createQueryBuilder('p')
           //->orderBy('p.created', 'DESC')
           ->getQuery();

       // No need to manually get get the result ($query->getResult())

       $paginator = $this->paginate($query, $page, $size);

       return $paginator;
    }

   /**
    * Paginator Helper
    *
    * Pass through a query object, current page & limit
    * the offset is calculated from the page and limit
    * returns an `Paginator` instance, which you can call the following on:
    *
    *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
    *     $paginator->count() # Count of ALL posts (ie: `20` posts)
    *     $paginator->getIterator() # ArrayIterator
    *
    * @param Doctrine\ORM\Query $dql   DQL Query Object
    * @param integer            $page  Current page (defaults to 1)
    * @param integer            $limit The total number per page (defaults to 5)
    *
    * @return \Doctrine\ORM\Tools\Pagination\Paginator
    */
    public function paginate(\Doctrine\ORM\Query $dql, int $page = 1, int $limit = 5)
    {
       $paginator = new Paginator($dql);

       $paginator->getQuery()
           ->setFirstResult($limit * ($page - 1)) // Offset
           ->setMaxResults($limit); // Limit

       return $paginator;
    }

    // /**
    //  * @return Beer[] Returns an array of Beer objects
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

    /*
    public function findOneBySomeField($value): ?Beer
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
