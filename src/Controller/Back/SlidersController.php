<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Sliders;
use App\Entity\SousSliders;
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
        $sliders = $dm->getRepository('App:Sliders')->findAll();
        return $this->render('Sliders/list.html.twig', array('sliders' => $sliders));
    }
    
    /*
     * Sliders list in front
     */
    public function listInFront()
    {
        $dm = $this->getDoctrine()->getManager();
        $sliders = $dm->getRepository('App:Sliders')->findAll();
        return $this->render('Sliders/front.html.twig', array('sliders' => $sliders));
    }
    
    /*
     * Slider details in front
     */
    public function showInFront(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $products_liste = array();
        $produit = $slider->getProduct();
        $categorie = $produit->getSousCategorie()->getId();
        $find_products = $dm->getRepository('App:Products')->liees($categorie);
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findBy(array('sousCategorie' => $categorie));
        $paginator  = $this->get('knp_paginator');
        
        foreach ($find_products as $p){
            if($p->getId()!=$produit->getId()){
                $products_liste[] = $p;
            }
        }
        $products = $paginator->paginate(
            $products_liste, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        $couleurs = $dm->getRepository('App:Products')->couleursProductsBycategories($categorie);
        $marques = $dm->getRepository('App:Marques')->findBy(array('sousCategorie' => $categorie));
        $products_price = array();
        foreach ($find_products as $product) {
            $products_price[] = $product->getPricePromotion()?$product->getPricePromotion():$product->getPrice();
        }
        $min = count($products_price) > 0 ? min($products_price) : 0;
        $max = count($products_price) > 0 ? max($products_price) : 0;
        return $this->render('Sliders/detailsFront.html.twig', array(
            'product' => $produit,
            'products' => $products,
            'categorie' => $produit->getSousCategorie(),
            'marques' => $marques,
            'couleurs' => $couleurs,
            'caracteristiques' => $caracteristiques,
            'min' => $min,
            'max'=>$max,
        ));
    }
    
    /*
     * CategorieMere details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $product = $dm->getRepository('App:Products')->find($slider->getProduct()->getId());
        return $this->render('Sliders/show.html.twig', array('slider' => $slider, 'product'=>$product));
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
        $product = $dm->getRepository('App:Products')->find($request->get('product'));
        $slider->setProduct($product);
        $slider->setOrdre($request->get('ordre'));
        if($request->get('status')){
           $slider->setStatus(1);
        }else{
            $slider->setStatus(0);
        }
        if (isset($_FILES["imageSlider"]["name"]) && !empty($_FILES["imageSlider"]["name"])) {
            $file = $_FILES["imageSlider"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["imageSlider"]["tmp_name"], $this->getParameter('images_sliders') . "/" . $fileName
            );
            $slider->setImage($fileName);
        }
        $dm->persist($slider);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Nouvelle slider pour le produit ".$product->getName());
        return $this->redirectToRoute('dashboard_product_details', array('id' => $product->getId()));
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
        }else{
            $slider->setImage($slider->getImage());
        }
        $dm->persist($slider);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La slider a été modifiée");
        return $this->redirectToRoute('dashboard_sliders_details', array('id' => $slider->getId()));
    }
    
    /*
     * Delete sliderMere
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_sliders')."/".$slider->getImage(), ''.$slider->getImage().''));
        $dm->remove($slider);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La slider est supprimée");
        $referer = $request->headers->get('referer');

return $this->redirect($referer);
    }
}
