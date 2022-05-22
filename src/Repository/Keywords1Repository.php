<?php

namespace App\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use App\Utils\EntityDocumentManager;
date_default_timezone_set("Europe/Paris");
/**
 * @method Keywords|null find($id, $lockMode = null, $lockVersion = null)
 * @method Keywords|null findOneBy(array $criteria, array $orderBy = null)
 * @method Keywords[]    findAll()
 * @method Keywords[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Keywords1Repository extends DocumentRepository
{
    public function byName($chaine)
    {
        $qb = $this->createQueryBuilder('u')
                ->Select('u.id', 'u.name')
                ->where('u.name LIKE :name')
                ->setParameter('name', '%'.$chaine.'%');

        return $qb->getQuery()->execute();
    }
}
