<?php

namespace App\Repository;

use App\Entity\ProductsLiees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductsLiees|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsLiees|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsLiees[]    findAll()
 * @method ProductsLiees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsLieesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsLiees::class);
    }

    // /**
    //  * @return ProductsLiees[] Returns an array of ProductsLiees objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductsLiees
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
