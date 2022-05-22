<?php

namespace App\Repository;

use App\Entity\AdressesStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AdressesStore|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdressesStore|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdressesStore[]    findAll()
 * @method AdressesStore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdressesStoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdressesStore::class);
    }

    // /**
    //  * @return AdressesStore[] Returns an array of AdressesStore objects
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
    public function findOneBySomeField($value): ?AdressesStore
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
