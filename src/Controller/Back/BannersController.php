<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Banners;
use App\Entity\SousBanners;
use App\Entity\ProductsList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class BannersController extends Controller
{
    /*
     * Banners list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $banners = $dm->getRepository('App:Banners')->findAll();
        
        return $this->render('Banners/back/list.html.twig', array('banners' => $banners));
    }
    /*
     * Banners principales
     */
    public function principalesAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $banners = $dm->getRepository('App:Banners')->principales();
        
        return $this->render('Banners/back/principales.html.twig', array('banners' => $banners));
    }
    /*
     * Banners 2 in front
     */
    public function bannersCategorie($id_categorie)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->findOneInIndex($id_categorie)[0];
        $banners = $dm->getRepository('App:Banners')->byCategorie($id_categorie);
        $products = array();
        if(isset($categorie['show_list_products']) && $categorie['show_list_products'] == 1 && count($banners) > 0){
            $products = $dm->getRepository('App:ListHasProducts')->byBanner($banners[0]['slug']);
        }
        return $this->render('Banners/front/banners.html.twig', array('banners' => $banners, 'categorie' => $categorie, 'products' => $products));
    }
    
    /*
     * Banners 2 in front
     */
    public function twoInFront()
    {
        $dm = $this->getDoctrine()->getManager();
        $banners = $dm->getRepository('App:Banners')->findBy(array('isTwo' => true));
        dump(count($banners));
        return $this->render('Banners/front/2banners.html.twig', array('banners' => $banners));
    }
    
    /*
     * Banners 3 in front
     */
    public function threeInFront()
    {
        $dm = $this->getDoctrine()->getManager();
        $banners = $dm->getRepository('App:Banners')->findBy(array('isThree' => true));
        
        return $this->render('Banners/front/3banners.html.twig', array('banners' => $banners));
    }
    
    /*
     * Banner details in front
     */
    public function showInFront(Request $request, $slug)
    {
        $dm = $this->getDoctrine()->getManager();
        $products_liste = array();
        $setting = $dm->getRepository('App:Settings')->find(1);
        $products = $dm->getRepository('App:ListHasProducts')->byBanner($slug);
        if(count($products) == 1){
            $product = $dm->getRepository('App:Products')->find($products[0]['id']);
            $caracteristiques = $dm->getRepository('App:Products')->produitsCriteres($product->getId());
            $query = array();
            $query['slug'] = $product->getSlug();
            $query['sousCategorie'] = $product->getSousCategorie();
            $productsLiees = array();
            $liees = $dm->getRepository('App:Others')->findBy(array('main' => $product->getId()));
            foreach ($liees as $liee) {
                $productsLiees[] = $liee->getLiee();
            }
            $query['liees'] = implode(', ', $productsLiees);
            $products = $dm->getRepository('App:Products')->produitsLiees($query);
            $product->setNbrView($product->getNbrView()+1);
            $dm->persist($product);
            $dm->flush();
            return $this->render('Products/front/details.html.twig', array(
                'id_product' => $product->getId(),
                'product' => $product,
                'products' => $products,
                'caracteristiques' => $caracteristiques,
                'categorie' => $product->getSousCategorie(),
                'setting' => $setting
            ));
        }
        
        $listProducts = $dm->getRepository('App:ProductsList')->getListesByBanner($slug)[0];
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
        return $this->render('Banners/front/detailsFront.html.twig', array(
            'products' => $products,
            'marques' => $marques,
            'caracteristiques' => $caracteristiques,
            'couleurs' => $couleurs,
            'listProducts' => $listProducts,
            'min' => $min,
            'max' => $max,
            'setting' => $setting
        ));
    }
    
    /*
     * CategorieMere details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $banner = $dm->getRepository('App:Banners')->find($id);
        $list_products = $dm->getRepository('App:ProductsList')->findOneBy(array('banner' => $banner));
        $products = $dm->getRepository('App:listHasProducts')->getProductListe($list_products->getId());
        return $this->render('Banners/back/show.html.twig', array('banner' => $banner, 'products'=>$products, 'list_products' => $list_products));
    }
    
    /*
     * New CategorieMere page
     */
    public function newAction()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('Banners/back/new.html.twig',array());
    }
    /*
     * New CategorieMere page
     */
    public function newByCategorieAction($categorie)
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('Banners/back/newByCategorie.html.twig',array('categorie' => $categorie));
    }
    
    /*
     * New CategorieMere traitement
     */
    public function newTraitementAction(Request $request)
    {
        
        $dm = $this->getDoctrine()->getManager();
        $banner = new Banners();
        
        if($request->get('isThree') && $request->get('isThree')){
            $request->getSession()->getFlashBag()->add('danger', "La banniére vous devez choisir une option : 2 par ligne ou 3 par ligne");
            return $this->redirectToRoute('dashboard_product_details', array('id' => $product->getId()));
        }else{
            if($request->get('status')){
               $banner->setStatus(1);
            }else{
                $banner->setStatus(0);
            }
            if($request->get('categorie') && !empty($request->get('categorie'))){
                $categorie = $dm->getRepository('App:SousCategories')->find($request->get('categorie'));
                $banner->setSousCategories($categorie);
            }
            $request->get('isTow')?$banner->setIsTwo(1):$banner->setIsTwo(0);
            $request->get('isThree')?$banner->setIsThree(1):$banner->setIsThree(0);
            if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
                $file = $_FILES["image"]["name"];
                $File_Ext = substr($file, strrpos($file, '.'));
                $fileName = md5(uniqid()) . $File_Ext;
                move_uploaded_file(
                        $_FILES["image"]["tmp_name"], $this->getParameter('images_banners') . "/" . $fileName
                );
                $banner->setImage($fileName);
            }else{
                $banner->setImage($banner->getImage());
            }
            $banner->setDebut(new \DateTime(''.$request->get('datedebut').''));
            $banner->setFin(new \DateTime(''.$request->get('datefin').''));
            $productsList = new ProductsList();
            if($request->get('titre') && !empty($request->get('titre'))){
                $slug = preg_replace('/[^A-Za-z0-9. -]/', '', $request->get('titre'));

                // Replace sequences of spaces with hyphen
                $slug = preg_replace('/  */', '-', $slug);

                // The above means "a space, followed by a space repeated zero or more times"
                // (should be equivalent to / +/)

                // You may also want to try this alternative:
                $slug = preg_replace('/\\s+/', '-', $slug);
                $p = $dm->getRepository('App:Products')->findOneBy(array('slug'=>$slug));
                $productsList->setSlug($slug);
                $productsList->setCouleur($request->get('couleur'));
                $productsList->setName($request->get('titre'));
            }
            $productsList->setBanner($banner);
            $dm->persist($productsList);
            $dm->persist($banner);
            $dm->flush();
            $request->getSession()->getFlashBag()->add('success', "La banniére a été ajoutée");
        }
        return $this->redirectToRoute('dashboard_banners_edit', array('id' => $banner->getId()));
    }
    
    /*
     * CategorieMere edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $banner = $dm->getRepository('App:Banners')->find($id);
        return $this->render('Banners/back/edit.html.twig', array('banner' => $banner));
    }
    
    /*
     * CategorieMere edit traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $banner = $dm->getRepository('App:Banners')->find($id);
        if($request->get('status')){
           $banner->setStatus(1);
        }else{
            $banner->setStatus(0);
        }
        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            $file = $_FILES["image"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["image"]["tmp_name"], $this->getParameter('images_banners') . "/" . $fileName
            );
            $banner->setImage($fileName);
        }
        $banner->setDebut(new \DateTime(''.$request->get('datedebut').''));
        $banner->setFin(new \DateTime(''.$request->get('datefin').''));
        if($request->get('titre') && !empty($request->get('titre'))){
            $productsList = $banner->getProductsList();
            $slug = preg_replace('/[^A-Za-z0-9. -]/', '', $request->get('titre'));

            // Replace sequences of spaces with hyphen
            $slug = preg_replace('/  */', '-', $slug);

            // The above means "a space, followed by a space repeated zero or more times"
            // (should be equivalent to / +/)

            // You may also want to try this alternative:
            $slug = preg_replace('/\\s+/', '-', $slug);
            $p = $dm->getRepository('App:Products')->findOneBy(array('slug'=>$slug));
            $productsList->setSlug($slug);
            $productsList->setCouleur($request->get('couleur'));
            $productsList->setName($request->get('titre'));
        }
        $dm->persist($banner);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La banniére a été modifiée");
        
        return $this->redirectToRoute('dashboard_banners_edit', array('id' => $banner->getId()));
    }
    
    /*
     * Delete banner
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $banner = $dm->getRepository('App:Banners')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_banners')."/".$banner->getImage(), ''.$banner->getImage().''));
        $listProducts = $dm->getRepository('App:ProductsList')->findOneBy(array('banner' => $id));
        if($listProducts){
            foreach ($listProducts->getListHasProducts() as $item) {
                $dm->remove($item);
            }
            $dm->remove($listProducts);

        }
        $dm->remove($banner);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La banniére est supprimée");
        return $this->redirectToRoute('dashboard_banners_index');;
    }
    /*
     * remove img from gallery banner
     */
    public function removeImgFromGalleryAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $banner = $dm->getRepository('App:Banners')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_banners')."/".$banner->getImage(), ''.$banner->getImage().''));
        $banner->setImage('');
        $dm->persist($banner);
        $dm->flush();
        return new JsonResponse([
            'message' => 'image supprimmé'
        ]);
    }
    /**
    *
    **/
    public function bannersOrderInCategorieAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $list_sorted = $request->request->get('list_sorted');
        $count = 1;

        foreach ($list_sorted as $item) {
            $id = $item[0];
            $position = $item[1];
            $banner = $dm->getRepository('App:Banners')->find($id);
            $banner->setPosition($position);
            $dm->persist($banner);
        }

        $dm->flush();

        return new JsonResponse([
            'message' => 'list sorted'
        ]);
    }
}
