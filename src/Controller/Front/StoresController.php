<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Stores;

class StoresController extends Controller
{
    /*
     * Stores list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $stores = $dm->getRepository('App:Stores')->findAll();
        return $this->render('stores/front/list.html.twig', array('stores' => $stores));
    }
    
    /*
     * Store details
     */
    public function showAction($slug)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->findOneBy(array('slug' => $slug));
        $setting = $dm->getRepository('App:Settings')->find(1);
        $products = $dm->getRepository('App:Products')->findbyStore($store->getId());
        $list_ids = array();
        $products_price = array();
        foreach ($products as $p){
            $products_liste[] = $p;
            $list_ids[] = $p['id'];
            $products_price[] = $p['pricePromotion']?$p['pricePromotion']:$p['price'];
        }
        
        
        $min = count($products_price) > 0 ? min($products_price) : 0;
        $max = count($products_price) > 0 ? max($products_price) : 0;
        $caracteristiques_liste = $dm->getRepository('App:Products')->BannerCriteres($list_ids);
        $caracteristiques = array();
        foreach ($caracteristiques_liste as $c) {
            $valeurs = $dm->getRepository('App:Valeurs')->byCaracteristique($c['id']);
            $caracteristiques[] = ['id' => $c['id'], 'name' => $c['name'], 'valeurs' => $valeurs];
        }
        $marques = $dm->getRepository('App:Products')->BannerMarques($list_ids);
        $couleurs = $dm->getRepository('App:Products')->BannerCouleurs($list_ids);
        return $this->render('stores/front/show.html.twig', array(
            'store' => $store,
            'products' => $products,
            'marques' => $marques,
            'caracteristiques' => $caracteristiques,
            'couleurs' => $couleurs,
            'min' => $min,
            'max' => $max,
            'setting' => $setting
        ));
    }
}
