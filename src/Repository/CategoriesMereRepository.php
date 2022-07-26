<?php

namespace App\Repository;

use App\Entity\CategoriesMere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoriesMere|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriesMere|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriesMere[]    findAll()
 * @method CategoriesMere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesMereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriesMere::class);
    }

    // /**
    //  * @return CategoriesMere[] Returns an array of CategoriesMere objects
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
    public function findOneBySomeField($value): ?CategoriesMere
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function liste()
    {
        $qb = $this->createQueryBuilder('u')
        ->select('u.id, u.name');
        return $qb->getQuery()->execute();
    }
}
