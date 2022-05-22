<?php

namespace App\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use App\Utils\EntityDocumentManager;
date_default_timezone_set("Europe/Paris");
/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends DocumentRepository
{
    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('Products')
                ->Select('id', 'name', 'price', 'image', 'store', 'qte', 'pricePromotion')
                ->field('_id')->in($array);

        return $qb->getQuery()->execute();
    }
    
    public function produitsLiees($params)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('_id')->notEqual($params['id'])
                ->field('sousCategorie')->equals($params['sousCategorie'])
                ->limit(4);

        return $qb->getQuery()->execute();
    }
    
    public function byQB($params, $disponible)
    {
        $qb = $this->createQueryBuilder('Products');
        $qb->field('name')->equals(new \MongoRegex('/.*'.$params.'.*/i'));
        $this->addFilters($qb, $disponible);
        return $qb->getQuery()->execute();
    }
    
    private function addFilters($qb, $params)
    {
        if($params == 'oui'){
            $qb->field('qte')->gt(0);
        }
        
        
       return $qb;
    }
    
    public function newProducts()
    {
        $qb = $this->createQueryBuilder('Products')
                ->sort('createdAt', 'desc');
        return $qb->getQuery()->execute();
    }
    
    public function venteFlash()
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('pricePromotion')->gt(0)
                ->sort('createdAt', 'desc');
        return $qb->getQuery()->execute();
    }
    
    public function inPromotion()
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('pricePromotion')->gt(0)
                ->sort('createdAt', 'desc');
        return $qb->getQuery()->execute();
    }
    
    public function byNbrViews($store)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('store')->equals($store)
                ->sort('nbrView', 'desc')
                ->field('nbrView')->gt(0)
                ->limit(6);
        return $qb->getQuery()->execute();
    }
    
    public function byNbrAddToCart($store)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('store')->equals($store)
                ->sort('nbrAddToCart', 'desc')
                ->field('nbrAddToCart')->gt(0)
                ->limit(6);
        return $qb->getQuery()->execute();
    }
    
    public function byNbrAddToFavorite($store)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('store')->equals($store)
                ->sort('nbrAddToFavorite', 'desc')
                ->field('nbrAddToFavorite')->gt(0)
                ->limit(6);
        return $qb->getQuery()->execute();
    }
    
    public function byPosAndSc($sousCategorie)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('sousCategorie.id')->equals($sousCategorie)
                ->sort('position', 'ASC');
        return $qb->getQuery()->execute();
    }
    
    public function liees($sousCategorie)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('sousCategorie.id')->equals($sousCategorie)
                ->sort('price', 'ASC');
        return $qb->getQuery()->execute();
    }
    
    public function byStore($store)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('store.id')->equals($store)
                ->sort('createdAt', 'desc');
        return $qb->getQuery()->execute();
    }
    
    public function byCategorie($params)
    {
        $qb = $this->createQueryBuilder('Products');
                
        if ((isset($params['minimum']) && !empty($params['minimum'])) && (isset($params['minimum'])&&!empty($params['minimum']))){
            $qb->field('price')->range($params['minimum'],$params['maximum']);
        }
        if(isset($params['tri'])&&!empty($params['tri'])){
            if ($params['tri'] == 1){
                $qb->sort('price', 'DESC');
            }elseif ($params['tri'] == 2){
                $qb->sort('price', 'ASC');
            }elseif ($params['tri'] == 3){
                $qb->sort('nbrView', 'DESC');
            }
        }
        if(isset($params['categorie'])&&!empty($params['categorie'])){
            $qb->field('sousCategorie.id')->equals($params['categorie']);
        }
        if(isset($params['store'])&&!empty($params['store'])){
            $qb->field('store.id')->equals($params['store']);
        }
        if(isset($params['categories'])&&!empty($params['categories'])){
            $qb->field('sousCategorie.id')->in($params['categories']);
        }
        return $qb->getQuery()->execute();
    }
    
    
    
    public function byKeyword($keyword)
    {
        $qb = $this->createQueryBuilder('Products')
                ->field('keywords.id')->in($keyword)
                ->sort('createdAt', 'desc');
        return $qb->getQuery()->execute();
    }

    
//    public function byPriceAsc()
//    {
//        $qb = $this->createQueryBuilder('Products')
//                ->sort('price', 'asc');
//        return $qb->getQuery()->execute();
//    }
//    
//    public function byPulaires()
//    {
//        $qb = $this->createQueryBuilder('Products')
//                ->sort('nbrView', 'desc');
//        return $qb->getQuery()->execute();
//    }
}
