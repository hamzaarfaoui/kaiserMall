<?php

namespace App\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use App\Utils\EntityDocumentManager;
date_default_timezone_set("Europe/Paris");
/**
 * @method MySite|null find($id, $lockMode = null, $lockVersion = null)
 * @method MySite|null findOneBy(array $criteria, array $orderBy = null)
 * @method MySite[]    findAll()
 * @method MySite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MySiteRepository extends DocumentRepository
{
    public function getVisites()
    {
        $qb = $this->createQueryBuilder('MySite')
                ->select('nbrVisite')
                ->field('nbrVisite')->gte(0)
                ->limit(1);

        return $qb->getQuery()->execute();
    }
}
