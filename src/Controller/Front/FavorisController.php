<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Favoris;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FavorisController extends Controller
{
    /*
     * Products in favavoris page
     */
    public function listAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $paginator  = $this->get('knp_paginator');
        ///
        $favoris = $dm->getRepository('App:Favoris')->findBy(array('user' => $this->getUser()));
        $find_products = array();
        foreach ($favoris as $f){
            $find_products[] = $f->getProduct();
        }
        $products = $paginator->paginate(
            $find_products, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('Products/front/favoris/favoris.html.twig', array('products' => $products));
    }
    
    /*
     * Add product in favoris
     */
    public function addFavoris($id)
    {
        $dm = $this->getDoctrine()->getManager();
        
        $product = $dm->getRepository('App:Products')->find($id);
        
        $favoris = $dm->getRepository('App:Favoris')->findBy(array('user' => $this->getUser()));
        $message ='';
        $products = array();
        foreach ($favoris as $f){
            
            $products [] = $f->getProduct();
            
        }
        if(!in_array($product, $products)){
            $favori = new Favoris();
            $favori->setProduct($product);
            $favori->setUser($this->getUser());
            $dm->persist($favori);
            $product->setNbrView($product->getNbrView()+1);
            $dm->persist($product);
            $dm->flush();
            $message = 'Produit ajouté à vos favoris';
        }else{
            $message = 'Produit déja dans vos favoris';
        }
        
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => $message
        ));
    }
    
    /*
     * Delete product from favoris
     */
    public function deleteFavoris($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = $dm->getRepository('App:Products')->find($id);
        $favori = $dm->getRepository('App:Favoris')->findOneBy(array('product' => $product, 'user' => $this->getUser()));
        $dm->remove($favori);
        $dm->flush();
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => 'Produit est retiré de vos favoris'
        ));
    }
    
    
}
