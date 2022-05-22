<?php

namespace App\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use App\Utils\EntityDocumentManager;
date_default_timezone_set("Europe/Paris");
/**
 * @method Stores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stores[]    findAll()
 * @method Stores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoresRepository extends DocumentRepository
{
    
    public function byname($params)
    {
        $qb = $this->createQueryBuilder('Stores');
        $qb->field('name')->equals(new \MongoRegex('/.*'.$params.'.*/i'));
        return $qb->getQuery()->execute();
    }
}
