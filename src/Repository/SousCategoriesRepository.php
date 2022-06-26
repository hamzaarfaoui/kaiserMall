<?php

namespace App\Repository;

use App\Entity\SousCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SousCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategories[]    findAll()
 * @method SousCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousCategories::class);
    }

    // /**
    //  * @return SousCategories[] Returns an array of SousCategories objects
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
    public function findOneBySomeField($value): ?SousCategories
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findOneByQB($id)
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.id', 'u.name', 'u.content', 'u.slug', 'u.image', 'u.show_products', 'u.show_banners', 'u.show_list_products', 'u.hasBanner')
                ->where('u.id = :id')->setMaxResults(1)
                ->setParameter(':id', $id);

        return $qb->getQuery()->execute();
    }
    public function findOneBySlug($slug)
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.id', 'u.name', 'u.content', 'u.image', 'u.show_products', 'u.show_banners', 'u.hasBanner')
                ->where('u.slug = :slug')->setMaxResults(1)
                ->setParameter(':slug', $slug);

        return $qb->getQuery()->execute();
    }
    public function findInIndex()
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.id', 'u.name', 'u.content', 'u.slug', 'u.orderInIndex', 'u.image', 'u.show_products', 'u.show_banners', 'u.hasBanner')
                ->where('u.showInIndex = 1')
                ->orderBy('u.orderInIndex', 'ASC');
        return $qb->getQuery()->execute();
    }
}
