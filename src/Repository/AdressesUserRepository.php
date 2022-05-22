<?php

namespace App\Repository;

use App\Entity\AdressesUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdressesUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdressesUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdressesUser[]    findAll()
 * @method AdressesUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdressesUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdressesUser::class);
    }

    // /**
    //  * @return AdressesUser[] Returns an array of AdressesUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdressesUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
