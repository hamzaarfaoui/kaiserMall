<?php

namespace App\Repository;

use App\Entity\MediasImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MediasImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediasImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediasImages[]    findAll()
 * @method MediasImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediasImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediasImages::class);
    }

    public function findByQB($id_product)
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.name as image')
                ->where('u.product = :id_product')
                ->setParameter(':id_product', $id_product);

        return $qb->getQuery()->execute();
    }
    public function findByQBMobile($id_product)
    {
        $qb = $this->createQueryBuilder('u')
                ->Select("CONCAT('https://www.kaisermall.tn/uploads/products/gallery/','',u.name) as image")
                ->where('u.product = :id_product')
                ->setParameter(':id_product', $id_product);

        return $qb->getQuery()->execute();
    }

    // /**
    //  * @return MediasImages[] Returns an array of MediasImages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MediasImages
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
