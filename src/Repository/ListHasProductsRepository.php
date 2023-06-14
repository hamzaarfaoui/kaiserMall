<?php

namespace App\Repository;

use App\Entity\ListHasProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListHasProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListHasProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListHasProducts[]    findAll()
 * @method ListHasProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListHasProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListHasProducts::class);
    }

    // /**
    //  * @return ListHasProducts[] Returns an array of ListHasProducts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListHasProducts
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function bySlider($slug)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('p.id', 'p.name', 'p.image', 'p.price', 'p.pricePromotion', 'p.qte', 'p.createdAt', 'p.slug', 'sc.id AS sc_id')
            ->leftJoin('u.product', 'p')
            ->leftJoin('p.sousCategorie', 'sc')
            ->leftJoin('u.listProduct', 'l')
            ->leftJoin('p.store', 's')
            ->where('s.debutOffre <= :deb')
            ->andWhere('s.finOffre >= :fin')
           ->andWhere('l.slug = :slug')
            ->orderBy('u.position', 'ASC')
            ->setParameter('deb', date('Y-m-d H:i:s'))
            ->setParameter('fin', date('Y-m-d H:i:s'))
            ->setParameter('slug', $slug);    
            
        
        return $qb->getQuery()->execute();
    }
    public function byBanner($slug)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('p.id', 'p.name', 'p.image', 'p.price', 'p.pricePromotion', 'p.qte', 'p.createdAt', 'p.slug', 'sc.id AS sc_id')
            ->leftJoin('u.product', 'p')
            ->leftJoin('p.sousCategorie', 'sc')
            ->leftJoin('u.listProduct', 'l')
            ->leftJoin('p.store', 's')
            ->where('s.debutOffre <= :deb')
            ->andWhere('s.finOffre >= :fin')
           ->andWhere('l.slug = :slug')
            ->orderBy('u.position', 'ASC')
            ->groupBy('p.id')
            ->setParameter('deb', date('Y-m-d H:i:s'))
            ->setParameter('fin', date('Y-m-d H:i:s'))
            ->setParameter('slug', $slug);    
            
        
        return $qb->getQuery()->execute();
    }
    public function byBannerMobile($slug)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('p.id', 'p.name', "CONCAT('https://www.kaisermall.tn/uploads/products/images/','',p.image) image", 'p.price', 'p.pricePromotion', 'p.qte', 'p.createdAt', 'p.slug', 'sc.id AS sc_id')
            ->leftJoin('u.product', 'p')
            ->leftJoin('p.sousCategorie', 'sc')
            ->leftJoin('u.listProduct', 'l')
            ->leftJoin('p.store', 's')
            ->where('s.debutOffre <= :deb')
            ->andWhere('s.finOffre >= :fin')
           ->andWhere('l.slug = :slug')
            ->orderBy('u.position', 'ASC')
            ->groupBy('p.id')
            ->setParameter('deb', date('Y-m-d H:i:s'))
            ->setParameter('fin', date('Y-m-d H:i:s'))
            ->setParameter('slug', $slug);    
            
        
        return $qb->getQuery()->execute();
    }
    public function getListes()
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.id', 'l.name', 'l.id AS id_list', 'p.image', 'p.id AS id_product', 's.image AS slider', 'b.image AS banner')
            ->leftJoin('u.listProduct', 'l')
            ->leftJoin('u.product', 'p')
            ->leftJoin('l.slider', 's')
            ->leftJoin('l.banner', 'b')
            ->groupBy('l.id');    
        
        return $qb->getQuery()->execute();
    }
    public function getProductListe($id_list)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.id', 'l.name', 'l.id AS id_list', 'p.id AS id_product', 'p.name AS name_product', 'p.image', 'p.price', 'p.pricePromotion', 'st.name AS store_name', 's.image AS slider', 'b.image AS banner')
            ->leftJoin('u.listProduct', 'l')
            ->leftJoin('u.product', 'p')
            ->leftJoin('p.store', 'st')
            ->leftJoin('l.slider', 's')
            ->leftJoin('l.banner', 'b')
            ->where('u.listProduct = :id_list')
            ->orderBy('u.position')
            ->setParameter('id_list', $id_list);    
            
        
        return $qb->getQuery()->execute();
    }
    public function byProdcutAndList($id_list, $id_product)
    {
        $qb = $this->createQueryBuilder('u');
            $qb
            ->Select('u.id')
            ->where('u.listProduct = :id_list')
            ->andWhere('u.product = :id_product')
            ->setParameter('id_list', $id_list)
            ->setParameter('id_product', $id_product);    
            
        
        return $qb->getQuery()->execute();
    }
}
