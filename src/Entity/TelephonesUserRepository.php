<?php

namespace App\Entity;

use App\Entity\TelephonesUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TelephonesUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TelephonesUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TelephonesUser[]    findAll()
 * @method TelephonesUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelephonesUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TelephonesUser::class);
    }

    // /**
    //  * @return TelephonesUser[] Returns an array of TelephonesUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TelephonesUser
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
