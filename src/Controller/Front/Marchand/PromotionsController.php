<?php

namespace App\Controller\Front\Marchand;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use App\Entity\User;
use App\Entity\Marchands;
use App\Entity\AdressesStore;
use App\Entity\AdressesUser;
use App\Entity\TelephonesUser;
use App\Entity\TelephonesStore;
use App\Entity\MediasImages;
use App\Entity\Promotions;
use App\Entity\Keywords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class PromotionsController extends Controller
{   
   
    
    /*
     * Promotions list
     */
    public function liste($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        $promotions_list = array();
        $products = $dm->getRepository('App:Products')->findBy(array('store' => $store));
        foreach ($products as $product){
            $promotion = $dm->getRepository('App:Promotions')->findOneBy(array('product' => $product));
            if($promotion)
            $promotions_list [] = $promotion;
        }
        return $this->render('promotions/marchand/index.html.twig', array('promotions' => $promotions_list, 'store' => $store));
    }
    
    
    
    
    
    /*
     * Edit Promotion
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $promotion = $dm->getRepository('App:Promotions')->find($id);

        $promotion->setDebut(new \DateTime(''.$request->get('datedebut').''));
        $promotion->setFin(new \DateTime(''.$request->get('datefin').''));
        $promotion->setFixe($request->get('fixe'));
        $promotion->setCreatedAt(new \DateTime('now'));
        $product = $promotion->getProduct();
        $product->setPricePromotion($request->get('fixe'));
        $dm->persist($promotion);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La promotion du produit ".$product->getName()." a été modifié");
        return $this->redirectToRoute('marchand_promotions_index', array('id' => $product->getStore()->getId()));
    }
    
    /*
     * Promotion delete
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $promotion = $dm->getRepository('App:Promotions')->find($id);
        $product = $promotion->getProduct();
        $product->setPricePromotion(null);
        $dm->remove($promotion);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La promotion du produit ".$product->getName()." est supprimé");
        return $this->redirectToRoute('marchand_promotions_index', array('id' => $product->getStore()->getId()));    }
}
