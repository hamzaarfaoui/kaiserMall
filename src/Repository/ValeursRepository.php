<?php

namespace App\Repository;

use App\Entity\Valeurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Valeurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valeurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valeurs[]    findAll()
 * @method Valeurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValeursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valeurs::class);
    }

    // /**
    //  * @return Valeurs[] Returns an array of Valeurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Valeurs
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
