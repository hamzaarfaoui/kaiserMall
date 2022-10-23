<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contacts;
use App\Entity\NewsLetter;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\MySite;

class FrontController extends Controller
{
    public function testEmail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('contact@kaisermall.tn')
        ->setTo('hamzaarfaoui105@gmail.com')
        ->setSubject('Kaiser Test Mail')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'test.html.twig'
            ),
            'text/html'
            )
        ;

        $mailer->send($message);
        $dm = $this->getDoctrine()->getManager();
        $sc2 = $dm->getRepository('App:SousCategories')->findBy(array('showInIndex' => 1));
        $categories = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('index.html.twig', array(
            'sc2' => $sc2,
            'categories' => $categories
        ));
    }
    /*
     * Index page
     */
    public function indexPage()
    {
        $dm = $this->getDoctrine()->getManager();
        $sc2 = $dm->getRepository('App:SousCategories')->findInIndex();
        $setting = $dm->getRepository('App:Settings')->find(1);
        $categories = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('index.html.twig', array(
            'sc2' => $sc2,
            'categories' => $categories,
            'setting' => $setting
        ));
    }
    public function productInIndex($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->findOneByQB($id)[0];
        $products = $dm->getRepository('App:Products')->listProductsBycategories($id,10);
        return $this->render('Products/front/index.html.twig', array(
            'products' => $products,
            'categorie' => $categorie
        ));
    }
    /*
     * New products
     */
    public function newProductsPage(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $find_products = $dm->getRepository('App:Products')->newProducts();
        $products_list = array();
        foreach ($find_products as $product){
            $products_list[] = $product;
        }
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $products_list, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            30 /*limit per page*/
        );
        return $this->render('frontend/nouveautes.html.twig', array(
            'products' => $products
        ));
    }
    
    /*
     * Vente flash
     */
    public function venteFlashPage(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $find_products = $dm->getRepository('App:Products')->venteFlash();
        $products_list = array();
        foreach ($find_products as $product){
            $products_list[] = $product;
        }
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $products_list, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            30 /*limit per page*/
        );
        return $this->render('frontend/venteFlash.html.twig', array(
            'products' => $products
        ));
    }
    
    /*
     * All stores
     */
    public function allStoresPage(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $find_stores = $dm->getRepository('App:Stores')->findAll();
        
        $paginator  = $this->get('knp_paginator');
        $stores = $paginator->paginate(
            $find_stores, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            30 /*limit per page*/
        );
        return $this->render('frontend/allStores.html.twig', array(
            'stores' => $stores
        ));
    }
    
    /*
     * All stores
     */
    public function searchStoresPage(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $find_stores = $dm->getRepository('App:Stores')->byname($request->get('searchStore'));
        $stores_list = array();
        foreach ($find_stores as $store){
            $stores_list[] = $store;
        }
        $paginator  = $this->get('knp_paginator');
        $stores = $paginator->paginate(
            $stores_list, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            30 /*limit per page*/
        );
        return $this->render('frontend/allStores.html.twig', array(
            'stores' => $stores
        ));
    }
    
    /*
     * Index page
     */
    public function navigation()
    {
        $dm = $this->getDoctrine()->getManager();
        $sc2 = $dm->getRepository('App:SousCategories')->findBy(array('showInIndex' => 1));
        $categories = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('includes/front/nav.html.twig', array(
            'categories' => $categories
        ));
    }
    /*
     * partial categories
     */
    public function partialCategories()
    {
        $dm = $this->getDoctrine()->getManager();
        $sc2 = $dm->getRepository('App:SousCategories')->findBy(array('showInIndex' => 1));
        $categories = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('categories/partial.html.twig', array(
            'categories' => $categories
        ));
    }
    
    /*
     * About page
     */
    public function aboutPage()
    {
        $dm = $this->getDoctrine()->getManager();
        $setting = $dm->getRepository('App:Settings')->find(1);
        return $this->render('frontend/about.html.twig', ['setting' => $setting]);
    }
    
    /*
     * Contact page
     */
    public function contactPage()
    {
        $dm = $this->getDoctrine()->getManager();
        $setting = $dm->getRepository('App:Settings')->find(1);
        return $this->render('frontend/contact.html.twig', ['setting' => $setting]);
    }
    
    /*
     * Contact Send
     */
    public function contactSend(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $contact = new Contacts();
        $contact->setCreatedAt(new \DateTime());
        $contact->setNom($request->get('nom'));
        $contact->setPrenom($request->get('prenom'));
        $contact->setEmail($request->get('email'));
        $contact->setPhone($request->get('phone'));
        $contact->setMessage($request->get('msg'));
        $dm->persist($contact);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Nous avons bien reçu votre message ".$contact->getNom()." ".$contact->getPrenom().", nous vous répondrons trés prochainement");
        return $this->redirectToRoute('contact_page');
    }
    
    /*
     * Contact Send
     */
    public function subscribeToNewsLetter(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $newsLetter = new NewsLetter();
        $newsLetter->setEmail($request->get('email'));
        $newsLetter->setCreatedAt(new \DateTime());
        $dm->persist($newsLetter);
        $dm->flush();
        return new JsonResponse(array('email' => $request->get('email')));
    }
    
    /*
     * Process order page
     */
    public function processOrderPage()
    {
         $dm = $this->getDoctrine()->getManager();
         $setting = $dm->getRepository('App:Settings')->find(1);
        return $this->render('frontend/processOrder.html.twig', ['setting' => $setting]);
    }
    
    /*
     * Product page
     */
    public function productPage($slug)
    {
        $dm = $this->getDoctrine()->getManager();
        //$product = $dm->getRepository('App:Products')->findOneBy(array('slug' => $slug));
        $product = $dm->getRepository('App:Products')->findOneBy(array('slug' => $slug));
        $query = array();
        
        $product->setNbrView($product->getNbrView()+1);
        $dm->persist($product);
        $dm->flush();
        $caracteristiques = $dm->getRepository('App:Products')->produitsCriteres($product->getId());
        $productsLiees = array();
        $liees = $dm->getRepository('App:Others')->findBy(array('main' => $product->getId()));
        foreach ($liees as $liee) {
            $productsLiees[] = $liee->getLiee();
        }
        $query['liees'] = implode(', ', $productsLiees);
        $products = $dm->getRepository('App:Products')->produitsLiees($query);
        return $this->render('Products/front/details.html.twig', array(
            'id_product' => $product->getId(),
            'product' => $product,
            'products' => $products,
            'caracteristiques' => $caracteristiques,
            'categorie' => $product->getSousCategorie()
        ));
    }
    
    /*
     * Product by category
     */
    public function productByCategory(Request $request, $slug)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->findOneBySlug($slug)[0];
        $products = $dm->getRepository('App:Products')->listProductsBycategories($categorie['id']);
        $setting = $dm->getRepository('App:Settings')->find(1);
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findBy(array('sousCategorie' => $categorie['id']));
        
        $marques = $dm->getRepository('App:Products')->marquesProductsBycategories($categorie['id']);
        $couleurs = $dm->getRepository('App:Products')->couleursProductsBycategories($categorie['id']);
        $products_price = array();
        foreach ($products as $product) {
            $products_price[] = $product['pricePromotion']?$product['pricePromotion']:$product['price'];
        }
        $min = count($products_price) > 0 ? min($products_price) : 0;
        $max = count($products_price) > 0 ? max($products_price) : 0;
        return $this->render('frontend/productsByCategory.html.twig', array(
            'products' => $products,
            'categorie' => $categorie,
            'marques' => $marques,
            'couleurs' => $couleurs,
            'caracteristiques' => $caracteristiques,
            'min' => $min,
            'max'=>$max,
            'setting' => $setting
        ));
    }
    
    /*
     * Store market
     */
    public function store(Request $request, $slug)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->findOneBy(array('slug' => $slug));
        $groups = $dm->getRepository('App:ProductsList')->findBy(array('store' => $store->getId()));
        $products = $dm->getRepository('App:Products')->findBy(array('store' => $store->getId()), array('createdAt' => 'DESC'));
        $categories = array();
        $marques = array();
        $caracteriqtiques = array();
        $products_price = array();
        $result = array();
        foreach ($products as $product){
            if(!in_array($product->getSousCategorie(), $categories)){
                $categories []= $product->getSousCategorie();
            }
            if(!in_array($product->getMarque(), $marques)){
                $marques []= $product->getMarque();
            }
            $result[] = $product;
            $products_price[] = $product->getPrice();
            
        }
        foreach ($categories as $categorie){
            if($categorie){
                foreach ($categorie->getCaracteristiques() as $c){
                    if(!in_array($c, $caracteriqtiques)){
                        $caracteriqtiques []= $c;
                    }
                }
            }
        }
        $min = min($products_price);
        $max = max($products_price);
        $paginator  = $this->get('knp_paginator');
        
        $products_list = $paginator->paginate(
            $result, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('frontend/store.html.twig', array(
            'products' => $products_list,
            'categories' => $categories,
            'marques' => $marques,
            'caracteriqtiques' => $caracteriqtiques,
            'min' => $min,
            'max'=>$max,
            'groups' => $groups,
            'store' => $store
        ));
    }
    
    /*
     * search result
     */
    public function searchResult(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $search = $request->get('search');
        //$products = $dm->getRepository('App:Products')->findAll();
        $keywords_array = $dm->getRepository('App:Keywords')->byName($search);
        $keywords = array();
        foreach ($keywords_array as $keyword) {
            $keywords[] = $keyword['id'];
        }
        $find_products = $dm->getRepository('App:Products')->byKeyword($keywords);
        
        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $find_products, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('frontend/searchResult.html.twig', array(
            'products' => $products,
            'search' => $search
        ));
    }
    
    /*
     * other filters result
     */
    public function otherFiltersResult()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('frontend/otherFiltersResult.html.twig');
    }
}
