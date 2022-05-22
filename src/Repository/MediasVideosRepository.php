<?php

namespace App\Repository;

use App\Entity\MediasVideos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MediasVideos|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediasVideos|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediasVideos[]    findAll()
 * @method MediasVideos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediasVideosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediasVideos::class);
    }

    // /**
    //  * @return MediasVideos[] Returns an array of MediasVideos objects
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
    public function findOneBySomeField($value): ?MediasVideos
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
