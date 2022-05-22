<?php

namespace App\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use App\Utils\EntityDocumentManager;
date_default_timezone_set("Europe/Paris");
/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends DocumentRepository
{
    public function liste()
    {
        $qb = $this->createQueryBuilder('Commandes')
                ->sort('createdAt', 'desc');
        return $qb->getQuery()->execute();
    }
    public function nombreCmdValide()
    {
        $qb = $this->createQueryBuilder('Commandes')
                ->field('status')->equals(1);
        return $qb->getQuery()->execute()->count();
    }
    public function nombreCmdEnCours()
    {
        $qb = $this->createQueryBuilder('Commandes')
                ->field('status')->equals(0);
        return $qb->getQuery()->execute()->count();
    }
    
    public function listeInDash()
    {
        $qb = $this->createQueryBuilder('Commandes')
                ->sort('createdAt', 'desc')
                ->limit(6);
        return $qb->getQuery()->execute();
    }
}
