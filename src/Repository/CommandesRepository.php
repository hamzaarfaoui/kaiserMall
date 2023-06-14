<?php

namespace App\Repository;

use App\Entity\Commandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }
    public function liste()
    {
        $qb = $this->createQueryBuilder('u')
                ->orderBy('u.createdAt', 'desc');
        return $qb->getQuery()->execute();
    }
    public function nombreCmdValide()
    {
        $qb = $this->createQueryBuilder('u')
        ->select('COUNT(u)')
                ->where('u.status = 1');
        return $qb->getQuery()
 ->getSingleScalarResult();
    }
    public function nombreCmdEnCours()
    {
        $qb = $this->createQueryBuilder('u')
        ->select('COUNT(u)')
                ->where('u.status = 0');
        return $qb->getQuery()
 ->getSingleScalarResult();
    }
    
    public function listeInDash($params)
    {
        $qb = $this->createQueryBuilder('u');
        
        
        if(isset($params['this_year'])){
            $qb->select('MONTH(u.createdAt) as date_cmd','COUNT(u.id) as nb_cmd', 'u.facture, u.id, u.status')
            ->groupBy('date_cmd');
        }else{
            $month = $params['month'];
            $qb->select('DAY(u.createdAt) as date_cmd','COUNT(u.id) as nb_cmd', 'u.facture, u.id, u.status')
            ->where('MONTH(u.createdAt) = :month')
            ->groupBy('date_cmd')
            ->setParameter('month', $month);
        }
            
        return $qb->getQuery()->execute();
    }
    // /**
    //  * @return Commandes[] Returns an array of Commandes objects
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
    public function findOneBySomeField($value): ?Commandes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
