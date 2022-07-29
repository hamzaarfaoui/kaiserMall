<?php

namespace App\Repository;

use App\Entity\Stores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stores[]    findAll()
 * @method Stores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stores::class);
    }

    public function byname($params)
    {
        $qb = $this->createQueryBuilder('Stores');
        $qb->field('name')->equals(new \MongoRegex('/.*'.$params.'.*/i'));
        return $qb->getQuery()->execute();
    }
    
    // /**
    //  * @return Stores[] Returns an array of Stores objects
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
    public function findOneBySomeField($value): ?Stores
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function listeInDash($params)
    {
        $qb = $this->createQueryBuilder('u');
        
        
        if(isset($params['this_year'])){
            $qb->select('MONTH(u.debutOffre) as date_offre','COUNT(DISTINCT(u.id)) as nb_offre','SUM(DISTINCT(u.prix)) as total_offre');
            $qb->groupBy('date_offre');
        }else{
            $month = $params['month'];
            $qb->select('DAY(u.debutOffre) as date_offre','COUNT(DISTINCT(u.id)) as nb_offre','SUM(DISTINCT(u.prix)) as total_offre');
            $qb->where('MONTH(u.debutOffre) = :month')->groupBy('date_offre');
            $qb->setParameter('month', $month);
        }
            
        return $qb->getQuery()->execute();
    }
}
