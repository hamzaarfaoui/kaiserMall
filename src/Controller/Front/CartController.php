<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\AdressesUser;
use App\Form\AdresseUserType;
use App\Form\AdresseType;

class CartController extends Controller
{
    /*
     * Page panier
     */
    public function cart(Request $request)
    {
        $session = $request->getSession();
        $dm = $this->getDoctrine()->getManager();
        if (!$session->has('panier')){$session->set('panier', array());}
        $products = $dm->getRepository('App:Products')->findArray(array_keys($session->get('panier')));
        return $this->render('frontend/cart/cart.html.twig', array(
            'products' => $products,
            'panier' => $session->get('panier')
        ));
    }
    
    /*
     * Calcul montant total et nombre de produits dans le panier
     */
    public function fetchTotalCart(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        
        $list = '';
        $list_in_table = '';
        $total = 0;
        $panier = $session->get('panier');
        if (!$session->has('panier')){
            $total = 0;
            $articles = 0;
            $array_product_ids = [];
        }else{
            $articles = count($session->get('panier'));
            $array_product_ids = $session->get('panier');
            $products = $dm->getRepository('App:Products')->findArray(array_keys($array_product_ids));
            if(count($products) > 0){
                foreach ($products as $product){
                    $price = $product->getPricePromotion()?$product->getPricePromotion():$product->getPrice();
                    $total+=$price*$panier[$product->getId()];
                    $list .= '<div class="product product-widget product-in-cart'.$product->getId().'">';
                    $list .= '<div class="product-thumb">'; 
                    $list .= '<img src="http://'.$_SERVER['HTTP_HOST'] . '/uploads/products/images/'. $product->getImage().'"/>';
                    $list .= '</div>';
                    $list .= '<div class="product-body">'; 
                    
                    $list .= '<h3 class="product-price">'.$price.' TND <span class="qty">1</span></h3>';
                    $list .= '<h2 class="product-name">'.$product->getName().'</h2>';
                    $list .= '</div>';
                    $list .= '<button class="cancel-btn" data-id="'.$product->getId().'"><i class="fa fa-trash"></i></button>';
                    $list .= '</div>';
                }
            }else{
                $list .= '<span style="text-align: center">Panier vide</span>';
                $list_in_table .= '<tr><td colspan="6" class="text-center"><strong>Votre panier est vide</strong></td></tr>';
            }
        }
        
        
        
        return new JsonResponse(array('status' => 'ok', 'total' => $total, 'qte' => $articles, 'products' => $list, 'products_table' => $list_in_table));
    }
    
    /*
     * Affichage des produits en panier dans le header
     */
    public function CartInHeader(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $array_product_ids = "";
        if (!$session->has('panier')){
            $articles = 0;
            $array_product_ids = [];
        }
        else{
            $articles = count($session->get('panier'));
            $array_product_ids = $session->get('panier');
        }
        if($session->get('panier') == ""){
            
        }
        $products = $dm->getRepository('App:Products')->findArray(array_keys($array_product_ids));
        return $this->render('frontend/cart/header.html.twig', array(
            'articles' => $articles,
            'products' => $products
        ));
    }
    
    /*
     * Ajout d'produit au panier 
     */
    public function addProductToCart(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        $product = $dm->getRepository('App:Products')->find($id);
        $product->setNbrAddToCart($product->getNbrAddToFavorite()+1);
        $dm->persist($product);
        $dm->flush();
        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) {$panier[$id] = $request->query->get('qte');}
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($request->query->get('qte') != null)
            {$panier[$id] = $request->query->get('qte');}
            else
            { $panier[$id] = 1;}
        }
        $session->set('panier',$panier);
        return new JsonResponse(array('status'=>'OK', 'message'=>'Produit ajouté en panier'));
    }
    
    
    /*
     * Modification de la quantité d'produit dans le panier 
     */
    public function setProductQte(Request $request, $id)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        
        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) {$panier[$id] = $request->query->get('qte');}
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($request->query->get('qte') != null)
            {$panier[$id] = $request->query->get('qte');}
            else
            { $panier[$id] = 1;}
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('cart_page');
    }
    
    /*
     * Retirer un produit du panier 
     */
    public function removeProductFromCart(Request $request, $id)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');
        
        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
        }
        return $this->redirectToRoute('fetch_total_cart');
    }
    
    /*
     * Adresse de livraison page 
     */
    public function livraison(Request $request){
        $utilisateur = $this->getUser();
        if($utilisateur){
        $form = $this->createForm(AdresseType::class, $utilisateur);
        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($utilisateur);
            $dm->flush();
            return $this->redirect($this->generateUrl('livraison_page'));

        }
        return $this->render('frontend/cart/livraison.html.twig', 
        array('utilisateur' => $utilisateur, 'form' => $form->createView(),'entity' => $utilisateur ));
        }else{
            return $this->redirect($this->generateUrl('fos_user_security_login'));
            
        }
        
    }
    
    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();
        
        if (!$session->has('adresse')) {$session->set('adresse',array());}
        $adresse = $session->get('adresse');
        
        if ($request->request->get('livraison') != null)
        {
            $adresse['livraison'] = $request->request->get('livraison');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }
        
        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }
    
    public function validation(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        if ($this->getUser())
        {
            $user = $this->getUser();
            $user->setAdressLivraison($request->get('adresse'));
            $user->setCityLivraison($request->get('city'));
            $dm->persist($user);
            $dm->flush();  
        }
        $prepareCommande = $this->forward('App\Controller\Front\CommandesController::prepareCommande');
        $commande = $dm->getRepository('App:Commandes')->find($prepareCommande->getContent());
        return $this->render('frontend/cart/validation.html.twig', array('commande' => $commande));
    }
}
