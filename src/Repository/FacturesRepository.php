<?php

namespace App\Repository;

use App\Entity\Factures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Factures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factures[]    findAll()
 * @method Factures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factures::class);
    }

    // /**
    //  * @return Factures[] Returns an array of Factures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Factures
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
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
            $qb->select('MONTH(c.createdAt) as date_cmd','COUNT(DISTINCT(c.id)) as nb_cmd');
            $qb->leftJoin('u.commande', 'c');
            if(isset($params['bymarchand']) && $params['bymarchand']){
                $qb->leftJoin('u.marchand', 'm');
                $qb->addSelect('m.name AS marchand');
                $qb->groupBy('u.marchand');
            }elseif(isset($params['bycategory']) && $params['bycategory']){
                $qb->leftJoin('u.product', 'p')
                ->addSelect('sc.name AS sousCategorie');
                ->groupBy('p.sousCategorie');
            }else{
            $qb->groupBy('date_cmd');
            }
        }else{
            $month = $params['month'];
            $qb->select('DAY(c.createdAt) as date_cmd','COUNT(c.id) as nb_cmd')
            ->leftJoin('u.commande', 'c');
            if(isset($params['bymarchand']) && $params['bymarchand']){
                $qb->leftJoin('u.marchand', 'm');
                $qb->addSelect('m.name AS marchand');
                $qb->groupBy('u.marchand');
            }elseif(isset($params['bycategory']) && $params['bycategory']){
                $qb->leftJoin('u.product', 'p')
                ->groupBy('p.sousCategorie');
            }else{
            $qb->groupBy('date_cmd');
            }
            $qb->where('MONTH(c.createdAt) = :month')
            ->groupBy('date_cmd')
            ->setParameter('month', $month);
        }
            
        return $qb->getQuery()->execute();
    }
}
