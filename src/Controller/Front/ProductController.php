<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    /*
     * Products list Front
     */
    public function listFrontAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $products = $dm->getRepository('App:Products')->findAll();
        return $this->render('Products/front/list.html.twig', array('products' => $products));
    }
    
    /*
     * New products
     */
    public function newProducts(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $find_products = $dm->getRepository('App:Products')->newProducts();
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $find_products, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('frontend/newProducts.html.twig', array('products' => $products));
    }
    
    /*
     * Products in promotion
     */
    public function productsInPromotion(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $find_products = $dm->getRepository('App:Products')->newProducts();
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $find_products, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('frontend/productsInPromotion.html.twig', array('products' => $products));
    }
    
    /*
     * Products Tri
     */
    public function triAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $query = array();
        $caracteristiques = [];
        $marques = [];
        $couleurs = [];
        if($request->get('inPromotion') && $request->get('inPromotion') == 1){
            $query['inPromotion'] = $caracteristiques;
        }
        if(!empty($request->get('caracteristiques'))){
            foreach ($request->get('caracteristiques') as $item){
                $valeur = $dm->getRepository('App:Valeurs')->find($item);
                $caracteristiques[] = $valeur->getId();
            }
            $query['valeurs'] = $caracteristiques;
        }
        if(!empty($request->get('marques'))){
			if($request->get('listProducts') || $request->get('store')){
				foreach ($request->get('marques') as $item){
					$marques[] = $item;
				}
			}else{
				foreach ($request->get('marques') as $item){
					$marque = $dm->getRepository('App:Marques')->find($item);
					$marques[] = $marque;
				}
			}
            $query['marques'] = $marques;
        }
        if(!empty($request->get('couleurs'))){
			if($request->get('listProducts') || $request->get('store')){
				foreach ($request->get('couleurs') as $item){
					$couleurs[] = $item;
				}
			}else{
				foreach ($request->get('couleurs') as $item){
					$couleur = $dm->getRepository('App:Couleurs')->find($item);
					$couleurs[] = $couleur;
				}
			}
            
            $query['couleurs'] = $couleurs;
        }
        if($request->get('categorie')){
            $query['categorie'] = $request->get('categorie');
        }
        if($request->get('listProducts')){
            $query['list'] = $request->get('listProducts');
        }
        if($request->get('store')){
            $query['store'] = $request->get('store');
        }
        $query['tri'] = $request->get('tri');
        $query['minimum'] = intval($request->get('min'));
        $query['maximum'] = intval($request->get('max'));
        if(!empty($request->get('store'))){
            $query['store'] = $request->get('store');
        }
        if (count($caracteristiques) >= 1) {$query['valeurs'] = $caracteristiques;}
        if(isset($query['categorie'])){
            $products_list = $dm->getRepository('App:Products')->byCategorie($query);
            $view = 'frontend/partials/triProduct.html.twig';
        }elseif(isset($query['store'])){
            $products_list = $dm->getRepository('App:Products')->triByStore($query);
            $view = 'frontend/partials/triProductStore.html.twig';
        }else{
            $products_list = $dm->getRepository('App:Products')->byBanner($query);
            $view = 'frontend/partials/triProductBanner.html.twig';
        }
        
        return new JsonResponse(array(
            'status' => 'OK',
            'range' => '('.intval($query['minimum']).') --- ('.intval($query['maximum']).') : '. count($products_list).' produits',
            'c' => $query['tri'],
            'nbr' => count($products_list),
            'message' => 'Tout est bon',
            'filter_by_categorie' => isset($query['categories']) ? true : false,
            'filter_by_listProducts' => isset($query['list']) ? true : false,
            'filter_by_store' => isset($query['store']) ? true : false,
            'products' => $this->renderView($view, array('products' => $products_list))
        ));
    }
}
