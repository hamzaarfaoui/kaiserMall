<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Sliders;
use App\Entity\SousSliders;
use App\Entity\ProductsList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class SlidersController extends Controller
{
    /*
     * Sliders list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $sliders = $dm->getRepository('App:Sliders')->getAllSliders();
        return $this->render('Sliders/list.html.twig', array('sliders' => $sliders));
    }
    
    /*
     * Sliders list in front
     */
    public function listInFront()
    {
        $dm = $this->getDoctrine()->getManager();
        $sliders = $dm->getRepository('App:Sliders')->getAllSliders();
        return $this->render('Sliders/front.html.twig', array('sliders' => $sliders));
    }
    
    /*
     * Slider details in front
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
        return $this->render('Sliders/detailsFront.html.twig', array(
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
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $products = $dm->getRepository('App:ListHasProducts')->bySlider($slider->getId());
        return $this->render('Sliders/show.html.twig', array('slider' => $slider, 'products' => $products));
    }
    
    /*
     * New CategorieMere page
     */
    public function newAction()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('Sliders/new.html.twig',array());
    }
    
    /*
     * New CategorieMere traitement
     */
    public function newTraitementAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = new Sliders();
        $slider->setOrdre($request->get('ordre'));
        if($request->get('status')){
           $slider->setStatus(1);
        }else{
            $slider->setStatus(0);
        }
        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            $file = $_FILES["image"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["image"]["tmp_name"], $this->getParameter('images_sliders') . "/" . $fileName
            );
            $slider->setImage($fileName);
        }
        $productsList = new ProductsList();
        if($request->get('titre') && !empty($request->get('titre'))){
            $productsList->setName($request->get('titre'));
            $slug = preg_replace('/[^A-Za-z0-9. -]/', '', $request->get('titre'));

            // Replace sequences of spaces with hyphen
            $slug = preg_replace('/  */', '-', $slug);

            // The above means "a space, followed by a space repeated zero or more times"
            // (should be equivalent to / +/)

            // You may also want to try this alternative:
            $slug = preg_replace('/\\s+/', '-', $slug);
            $p = $dm->getRepository('App:Products')->findOneBy(array('slug'=>$slug));
            $productsList->setSlug($slug);
        }
        $productsList->setSlider($slider);
        $dm->persist($productsList);
        $dm->persist($slider);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Nouvelle slider ajouté ");
        return $this->redirectToRoute('dashboard_sliders_index');
    }
    
    /*
     * CategorieMere edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        return $this->render('Sliders/edit.html.twig', array('slider' => $slider));
    }
    
    /*
     * Slider edit traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        if($request->get('status')){
           $slider->setStatus(1);
        }else{
            $slider->setStatus(0);
        }
        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            $file = $_FILES["image"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["image"]["tmp_name"], $this->getParameter('images_sliders') . "/" . $fileName
            );
            $slider->setImage($fileName);
        }
        if($request->get('titre') && !empty($request->get('titre'))){
            $productsList = $slider->getProductsList();
            $productsList->setName($request->get('titre'));
            $slug = preg_replace('/[^A-Za-z0-9. -]/', '', $request->get('titre'));

            // Replace sequences of spaces with hyphen
            $slug = preg_replace('/  */', '-', $slug);

            // The above means "a space, followed by a space repeated zero or more times"
            // (should be equivalent to / +/)

            // You may also want to try this alternative:
            $slug = preg_replace('/\\s+/', '-', $slug);
            $p = $dm->getRepository('App:Products')->findOneBy(array('slug'=>$slug));
            $productsList->setSlug($slug);
        }
        $dm->persist($slider);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La slider a été modifiée");
        return $this->redirectToRoute('dashboard_sliders_index');
    }
    
    /*
     * Delete sliderMere
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $productsList = $dm->getRepository('App:ProductsList')->findOneBy(array('slider' => $slider));
        foreach ($productsList->getListHasProducts() as $item) {
            $dm->remove($item);
            $dm->flush();
        }
        $dm->remove($productsList);
        $dm->flush();
        $fileSystem->remove(array('symlink', $this->getParameter('images_sliders')."/".$slider->getImage(), ''.$slider->getImage().''));
        $dm->remove($slider);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La slider est supprimée");
        $referer = $request->headers->get('referer');

        return $this->redirectToRoute('dashboard_sliders_index');
    }
    /*
     * remove img from gallery slider
     */
    public function removeImgFromGalleryAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $image = $slider->getImage();
        $fileSystem->remove(array('symlink', $this->getParameter('images_sliders')."/".$image, ''.$image.''));
        $slider->setImage('');
        $dm->persist($slider);
        $dm->flush();
        return new JsonResponse([
            'message' => 'image supprimmé'
        ]);
    }
    /*
     * sliders order in index
     */
    public function slidersOrderInIndexAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $list_sorted = $request->request->get('list_sorted');
        $count = 1;

        foreach ($list_sorted as $item) {
            $id = $item[0];
            $position = $item[1];
            $slider = $dm->getRepository('App:Sliders')->find($id);
            $slider->setOrdre($position);
            $dm->persist($slider);
        }

        $dm->flush();

        return new JsonResponse([
            'message' => 'list sorted'
        ]);
    }
}
