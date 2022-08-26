<?php

namespace App\Repository;

use App\Entity\Others;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Others|null find($id, $lockMode = null, $lockVersion = null)
 * @method Others|null findOneBy(array $criteria, array $orderBy = null)
 * @method Others[]    findAll()
 * @method Others[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OthersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Others::class);
    }

    // /**
    //  * @return Others[] Returns an array of Others objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Others
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
