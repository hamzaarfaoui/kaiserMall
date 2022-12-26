<?php

namespace App\Repository;

use App\Entity\Sliders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sliders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sliders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sliders[]    findAll()
 * @method Sliders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlidersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sliders::class);
    }

    // /**
    //  * @return Sliders[] Returns an array of Sliders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sliders
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getAllSliders()
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.id', 'u.image', 'l.name AS list_name', 'l.id AS list_id', 'l.slug', 'COUNT(p.id) as nb_products')
            ->leftJoin('u.productsList', 'l')
            ->leftJoin('l.listHasProducts', 'p')
            ->groupBy('l.id')
            ->orderBy('u.ordre', 'ASC');
        
        return $qb->getQuery()->execute();
    }
    public function getAllSlidersMobile()
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('l.id AS id', "CONCAT('https://www.kaisermall.tn/uploads/sliders/','',u.image) AS image")
            ->leftJoin('u.productsList', 'l')
            ->leftJoin('l.listHasProducts', 'p')
            ->groupBy('l.id')
            ->orderBy('u.ordre', 'ASC');
        
        return $qb->getQuery()->execute();
    }
}
