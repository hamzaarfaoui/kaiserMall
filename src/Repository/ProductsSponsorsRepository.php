<?php

namespace App\Repository;

use App\Entity\ProductsSponsors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductsSponsors|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsSponsors|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsSponsors[]    findAll()
 * @method ProductsSponsors[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsSponsorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsSponsors::class);
    }

    // /**
    //  * @return ProductsSponsors[] Returns an array of ProductsSponsors objects
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
    public function findOneBySomeField($value): ?ProductsSponsors
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
