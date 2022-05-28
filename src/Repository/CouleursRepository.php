<?php

namespace App\Repository;

use App\Entity\Couleurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Couleurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Couleurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Couleurs[]    findAll()
 * @method Couleurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouleursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Couleurs::class);
    }

    // /**
    //  * @return Couleurs[] Returns an array of Couleurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Couleurs
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
