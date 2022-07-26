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
                ->leftJoin('p.sousCategorie', 'sc')
                ->leftJoin('sc.categorie', 'cat')
                ->leftJoin('cat.categorieMere', 'cm');
                if(isset($params['sousCategory']) && $params['sousCategory'] > 0){
                    $qb->addSelect('sc.name AS categorie')
                    ->where('cat.id = :id')
                    ->groupBy('sc.id')
                    ->setParameter('id', $params['sousCategory']);
                }elseif(isset($params['categoriesMere']) && $params['categoriesMere'] > 0){
                    $qb->addSelect('cat.name AS categorie')
                    ->where('cm.id = :id')
                    ->groupBy('cat.id')
                    ->setParameter('id', $params['categoriesMere']);
                }else{
                    $qb->addSelect('cm.name AS categorie')
                    ->groupBy('cm.id');
                }
                
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
                ->leftJoin('p.sousCategorie', 'sc')
                ->leftJoin('sc.categorie', 'cat')
                ->leftJoin('cat.categorieMere', 'cm');
                if(isset($params['sousCategory']) && $params['sousCategory'] > 0){
                    $qb->addSelect('sc.name AS categorie')
                    ->where('MONTH(c.createdAt) = :month')
                    ->andWhere('cat.id = :id')
                    ->groupBy('sc.id')
                    ->setParameter('id', $params['sousCategory']);
                }elseif(isset($params['categoriesMere']) && $params['categoriesMere'] > 0){
                    $qb->addSelect('cat.name AS categorie')
                    ->where('MONTH(c.createdAt) = :month')
                    ->andWhere('cm.id = :id')
                    ->groupBy('cat.id')
                    ->setParameter('id', $params['categoriesMere']);
                }else{
                    $qb->addSelect('cm.name AS categorie')
                    ->where('MONTH(c.createdAt) = :month')
                    ->groupBy('cm.id');
                }
            }else{
            $qb->where('MONTH(c.createdAt) = :month')->groupBy('date_cmd');
            }
            $qb->setParameter('month', $month);
        }
            
        return $qb->getQuery()->execute();
    }
}
