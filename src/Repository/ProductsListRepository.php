<?php

namespace App\Repository;

use App\Entity\ProductsList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductsList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsList[]    findAll()
 * @method ProductsList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsList::class);
    }

    // /**
    //  * @return ProductsList[] Returns an array of ProductsList objects
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
    public function findOneBySomeField($value): ?ProductsList
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getListes()
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.id AS id_list', 'u.name', 's.image AS slider', 'b.image AS banner')
            ->leftJoin('u.slider', 's')
            ->leftJoin('u.banner', 'b');
        
        return $qb->getQuery()->execute();
    }
    public function getListesBySlider($slider)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.name', 's.image AS slider')
            ->leftJoin('u.slider', 's')
            ->where('u.slider = :slider')
            ->setParameter('slider', $slider);
        
        return $qb->getQuery()->execute();
    }

    public function getListesByBanner($banner)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.name', 'b.image AS banner')
            ->leftJoin('u.banner', 'b')
            ->where('u.banner = :banner')
            ->setParameter('banner', $banner);
        
        return $qb->getQuery()->execute();
    }
}
