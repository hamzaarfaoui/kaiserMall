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

class ProductsController extends Controller
{   
   
    
    /*
     * Products list
     */
    public function liste($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        $products = $dm->getRepository('App:Products')->findBy(array('store' => $store));
        return $this->render('Products/marchand/index.html.twig', array('products' => $products, 'store' => $store));
    }
    
    /*
     * Products list in dashbord
     */
    public function listeInDash($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        $productsByNbrViews = $dm->getRepository('App:Products')->byNbrViews($store);
        $productsByNbrAddToCart = $dm->getRepository('App:Products')->byNbrAddToCart($store);
        $productsByNbrAddToFavorite = $dm->getRepository('App:Products')->byNbrAddToFavorite($store);
        return $this->render('Products/marchand/dash.html.twig', array(
            'productsByNbrViews'=>$productsByNbrViews,
            'productsByNbrAddToCart' => $productsByNbrAddToCart,
            'productsByNbrAddToFavorite' => $productsByNbrAddToFavorite,
            'store' => $store
                ));
    }
    
    /*
     * Product details
     */
    public function details($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = $dm->getRepository('App:Products')->find($id);
        $banner = $dm->getRepository('App:Banners')->findOneBy(array('product' => $product));
        $slider = $dm->getRepository('App:Sliders')->findOneBy(array('product' => $product));
        $sliders = $dm->getRepository('App:Sliders')->findAll();
        return $this->render('Products/marchand/show.html.twig', array(
            'product' => $product
            , 'banner' => $banner,
            'slider' => $slider,
            'sliders' => $sliders
                ));
    }
    
    /*
     * New Product page
     */
    public function newProduct($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        $categoriesMere = $dm->getRepository('App:CategoriesMere')->findAll();
        $sousCategories1 = $dm->getRepository('App:Categories')->findAll();
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findAll();
        $sousCategories2 = $dm->getRepository('App:SousCategories')->findAll();
        $marques = $dm->getRepository('App:Marques')->findAll();
        $stores = $dm->getRepository('App:Stores')->findAll();
        $products = $dm->getRepository('App:Products')->findBy(array('store'=>$store));
        return $this->render('Products/marchand/new.html.twig', array(
            'store' => $store,
            'categoriesMere' => $categoriesMere,
            'caracteristiques' => $caracteristiques,
            'stores' => $stores,
            'sousCategories1' => $sousCategories1,
            'sousCategories2' => $sousCategories2,
            'marques' => $marques
        ));
    }
    
    /*
     * New Product traitement
     */
    public function newProductTraitement(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = new Products();
        $product->setName($request->get('nom'));
        $product->setPrice($request->get('price'));
        $product->setQte($request->get('qte'));
        $product->setContent($request->get('descriptionC'));
        $store = $dm->getRepository('App:Stores')->find($id);
        $store->addProduct($product);
        $product->setStore($store);
        $product->setNbrAddToCart(0);
        $slug = preg_replace('/[^A-Za-z0-9. -]/', '', $request->get('nom'));

        // Replace sequences of spaces with hyphen
        $slug = preg_replace('/  */', '-', $slug);

        // The above means "a space, followed by a space repeated zero or more times"
        // (should be equivalent to / +/)

        // You may also want to try this alternative:
        $slug = preg_replace('/\\s+/', '-', $slug);
        $p = $dm->getRepository('App:Products')->findOneBy(array('slug'=>$slug));
        if($p){$slug = $slug.rand(1,25412).'-'.rand(1,2541222).$request->get('price').$request->get('qte');}
        $product->setSlug($slug);
        $product->setNbrView(0);
        $product->setNbrAddToFavorite(0);
        if($request->get('marque')){
        $marque_id = $request->get('marque');
        $marque = $dm->getRepository('App:Marques')->find($marque_id);
        $product->setMarque($marque);
        }
        $dm->persist($store);
        if($request->get('sc')){
            $sc = $dm->getRepository('App:SousCategories')->find($request->get('sc'));
            $product->setSousCategorie($sc);
        }
        /*start medias Images document*/
        if (isset($_FILES["images"]['name']) && !empty($_FILES["images"]['name'])) {
            for ($count = 0; $count < count($_FILES["images"]["name"]); $count++) {
                if(isset($_FILES["images"]['name']) && !empty($_FILES['images']['name'][$count])){
                    $mediaImage = new MediasImages();
                    $file = $_FILES['images']['name'][$count];
                    $File_Ext = substr($file, strrpos($file, '.'));
                    $fileName = md5(uniqid()) . $File_Ext;
                    $path = $this->getParameter('images_products_img_gallery') . '/' . $fileName;
                    move_uploaded_file($_FILES['images']['tmp_name'][$count], $path);
                    $mediaImage->setName($fileName);
                    $mediaImage->setProduct($product);
                    $dm->persist($mediaImage);
                }
            }
        }
        /*end medias Images document*/
        if (isset($_FILES["iconeC"]['name']) && !empty($_FILES["iconeC"]['name'])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_products_img') . "/" . $fileName
            );
            $product->setImage($fileName);
        }
        /*start promotion document*/
        if($request->get('datedebut') && $request->get('datefin') && $request->get('fixe')){
            $promotion = null;
            if($request->get('promotion')){
                $promotion = $dm->getRepository('App:Promotions')->find($request->get('promotion'));
            }else{
                $promotion = new Promotions(); 
                $promotion->setProduct($product);
            }

            $promotion->setDebut(new \DateTime(''.$request->get('datedebut').''));
            $promotion->setFin(new \DateTime(''.$request->get('datefin').''));
            $promotion->setFixe($request->get('fixe'));
            $promotion->setCreatedAt(new \DateTime('now'));
            $product->setPricePromotion($request->get('fixe'));
            $dm->persist($promotion);
        }
        /*end promotion document*/
        /*start Caractéristique valeur document*/
        $valeurs = $request->get('valeurs');
        foreach ($valeurs as $v){
            $valeur = $dm->getRepository('App:Valeurs')->find($v);
            $product->addValeur($valeur);
            $dm->persist($product);
        }

        /*start keywords*/
        $keywords_input = $request->get('keywords');
        $keywords_array = explode(",", $keywords_input);
        foreach ($keywords_array as $item) {
            $keyword = new Keywords();
            $keyword->setName($item);
            $keyword->setProduct($product);
            $keyword->setCategorie($product->getSousCategorie());
            $dm->persist($keyword);
            $product->addKeyword($keyword);
        }
        
        /*end kewords*/
        if($request->get('couleur')){
            $couleur = $dm->getRepository('App:Couleurs')->find($request->get('couleur'));
            $product->setCouleur($couleur);
        }
        /*start Caractéristique valeur document*/
        $dm->persist($product);
        /*end store document*/
        
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le produit ".$product->getName()." a été ajoutée");
        return $this->redirectToRoute('marchand_product_back_edit', array('id' => $product->getId()));
    }
    
    
    /*
     * Product edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = $dm->getRepository('App:Products')->find($id);
        $promotion = $dm->getRepository('App:Promotions')->findOneBy(array('product' => $product));
        $medias = $dm->getRepository('App:MediasImages')->findBy(array('product' => $product));
        $categoriesMere = $dm->getRepository('App:CategoriesMere')->findAll();
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findBy(array('sousCategorie' => $product->getSousCategorie()));
        $stores = $dm->getRepository('App:Stores')->findAll();
        $couleurs = $dm->getRepository('App:couleurs')->findBy(array('sousCategorie' => $product->getSousCategorie()));
        return $this->render('Products/marchand/edit.html.twig', array(
            'product' => $product,
            'categoriesMere' => $categoriesMere,
            'caracteristiques' => $caracteristiques,
            'promotion' => $promotion,
            'stores' => $stores,
            'couleurs' => $couleurs,
            'medias'=>$medias,
                ));
    }
    
    /*
     * Edit Product traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = $dm->getRepository('App:Products')->find($id);
        $product->setName($request->get('nom'));
        $product->setFullName($request->get('nom'));
        $product->setPrice($request->get('price'));
        $product->setQte($request->get('qte'));
        $product->setContent($request->get('descriptionC'));
        
        $valeurs = $request->get('valeurs');
        /*start medias Images document*/
        if (isset($_FILES["images"]['name']) && !empty($_FILES["images"]['name']) && count($_FILES["images"]['name']) > 0 && $_FILES["images"]["name"][0] != "") {
            for ($count = 0; $count < count($_FILES["images"]["name"]); $count++) {
                
                $mediaImage = new MediasImages();
                $file = $_FILES['images']['name'][$count];
                $File_Ext = substr($file, strrpos($file, '.'));
                $fileName = md5(uniqid()) . $File_Ext;
                $path = $this->getParameter('images_products_img_gallery') . '/' . $fileName;
                move_uploaded_file($_FILES['images']['tmp_name'][$count], $path);
                $mediaImage->setName($fileName);
                $mediaImage->setProduct($product);
                $dm->persist($mediaImage);
            }
        }
        /*end medias Images document*/
        if (isset($_FILES["iconeC"]['name']) && !empty($_FILES["iconeC"]['name'])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_products_img') . "/" . $fileName
            );
            $product->setImage($fileName);
        }
        if($request->get('datedeb') && $request->get('datefin') && $request->get('fixe')){
            if($request->get('promotion')){
                $promotion = $dm->getRepository('App:Promotions')->find($request->get('promotion'));
            }else{
                $promotion = new Promotions(); 
                $promotion->setProduct($product);
            }

            $promotion->setDebut(new \DateTime(''.$request->get('datedebut').''));
            $promotion->setFin(new \DateTime(''.$request->get('datefin').''));
            $promotion->setFixe($request->get('fixe'));
            $promotion->setUpdatedAt(new \DateTime('now'));
            $product->setPricePromotion($request->get('fixe'));
            $dm->persist($promotion);
        }
        /*end promotion document*/
        /*start Caractéristique valeur document*/
        /* remove products valeurs */
        foreach ($product->getValeurs() as $valeur) {
            $product->removeValeur($valeur);
            $dm->persist($product);
        }
        /* add selected valeurs */
        foreach ($valeurs as $v){
            $valeur = $dm->getRepository('App:Valeurs')->find($v);
            $product->addValeur($valeur);
            $dm->persist($product);
        }
        
        /*start keywords*/
        $keywords_input = $request->get('keywords');
        $keywords_array = explode(",", $keywords_input);
        $keywords_product = $dm->getRepository('App:Keywords')->findBy(array('product'=>$product));
        foreach ($keywords_product as $k){
            $product->removeKeyword($k);
            $dm->remove($k);
        }
        foreach ($keywords_array as $item) {
                $keyword = new Keywords();
                $keyword->setName($item);
                $keyword->setProduct($product);
                $keyword->setCategorie($product->getSousCategorie());
                $dm->persist($keyword);
                $product->addKeyword($keyword);
        }
        
        /*end kewords*/
        /*start Caractéristique valeur document*/
        $dm->persist($product);
        /*end store document*/
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le produit ".$product->getName()." a été modifié");
        return $this->redirectToRoute('marchand_product_back_edit', array('id' => $product->getId()));
    }
    
    /*
     * Product delete
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $product = $dm->getRepository('App:Products')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_products_img')."/".$product->getImage(), ''.$product->getImage().''));
        foreach ($product->getMediasImages() as $image){
            $fileSystem->remove(array('symlink', $this->getParameter('images_products_img_gallery')."/".$image->getName(), ''.$image->getName().''));
            $dm->remove($image);
        }
        $banners = $dm->getRepository('App:Banners')->findBy(array('product' => $product));
        foreach ($banners as $image){
            $fileSystem->remove(array('symlink', $this->getParameter('images_banners')."/".$image->getImage(), ''.$image->getImage().''));
            $dm->remove($image);
        }
        $sliders = $dm->getRepository('App:Sliders')->findBy(array('product' => $product));
        foreach ($sliders as $image){
            $fileSystem->remove(array('symlink', $this->getParameter('images_sliders')."/".$image->getImage(), ''.$image->getImage().''));
            $dm->remove($image);
        }
        $dm->remove($product);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le produit ".$product->getName()." est supprimé");
        return $this->redirectToRoute('marchand_product_index', array('id' => $product->getStore()->getId()));
    }
    
    /*
     * Delete product image
     */
    public function deleteProductImage(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $product = $dm->getRepository('App:Products')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_products_img')."/".$product->getImage(), ''.$product->getImage().''));
        $product->setImage(null);
        $dm->persist($product);
        $dm->flush();
        return new JsonResponse(array('message' => 'image supprimer'));
    }
    
    /*
     * Delete product image gallery
     */
    public function deleteProductImageGallery(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $image = $dm->getRepository('App:MediasImages')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_products_img_gallery')."/".$image->getName(), ''.$image->getName().''));
        $dm->remove($image);
        $dm->flush();
        return new JsonResponse(array('message' => 'image supprimer'));
    }
}
