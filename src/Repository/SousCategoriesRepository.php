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
                ->Select('u.id', 'u.name', 'u.content', 'u.slug', 'u.image', 'u.show_products', 'u.show_banners', 'u.show_list_products', 'u.hasBanner', 'c.id AS categorieId', 'c.name AS categorieName', 'cm.id AS categorieMereId', 'cm.name AS categorieMereName')
                ->leftJoin('u.categorie', 'c')
				->leftJoin('c.categorieMere', 'cm')
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
                ->Select('u.id', 'u.name', 'u.content', 'u.slug', 'u.orderInIndex', 'u.image', 'u.show_products', 'u.show_banners', 'u.hasBanner', 'u.show_list_products', 'COUNT(b.id) AS banners')
                ->leftJoin('u.banners', 'b')
                ->where('u.showInIndex = 1')
                ->groupBy('u.id')
                ->orderBy('u.orderInIndex', 'ASC');
        return $qb->getQuery()->execute();
    }
    public function findNotInIndex()
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.id', 'u.name', 'u.content', 'u.slug', 'u.orderInIndex', 'u.image', 'u.show_products', 'u.show_banners', 'u.hasBanner', 'u.show_list_products')
                ->where('u.showInIndex = 0')
                ->orWhere('u.showInIndex IS NULL')

                ->orderBy('u.name', 'ASC');
        return $qb->getQuery()->execute();
    }
    public function findOneInIndex($id)
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.id', 'u.name', 'u.content', 'u.slug', 'u.orderInIndex', 'u.image', 'u.show_products', 'u.show_banners', 'u.hasBanner', 'u.show_list_products')
                ->where('u.id = :id')
                ->orderBy('u.orderInIndex', 'ASC')
                ->setMaxResults(1)
                ->setParameter(':id', $id);
        return $qb->getQuery()->execute();
    }
}
