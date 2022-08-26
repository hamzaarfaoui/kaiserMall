<?php

namespace App\Repository;

use App\Entity\Liees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Liees|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liees|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liees[]    findAll()
 * @method Liees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Liees::class);
    }

    // /**
    //  * @return Liees[] Returns an array of Liees objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Liees
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
