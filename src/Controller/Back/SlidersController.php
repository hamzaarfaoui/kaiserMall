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
    public function showInFront(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = $dm->getRepository('App:Sliders')->find($id);
        $products_liste = array();
        $find_products = $dm->getRepository('App:ListHasProducts')->bySlider($slider->getId());
        
        $paginator  = $this->get('knp_paginator');
        $listProducts = $dm->getRepository('App:ProductsList')->getListesBySlider($slider->getId())[0];
        
        foreach ($find_products as $p){
            $products_liste[] = $p;
        }
        $products = $paginator->paginate(
            $products_liste, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        return $this->render('Sliders/detailsFront.html.twig', array(
            'products' => $products,
            'listProducts' => $listProducts
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
        if (isset($_FILES["imageSlider"]["name"]) && !empty($_FILES["imageSlider"]["name"])) {
            $file = $_FILES["imageSlider"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["imageSlider"]["tmp_name"], $this->getParameter('images_sliders') . "/" . $fileName
            );
            $slider->setImage($fileName);
        }
        $productsList = new ProductsList();
        if($request->get('titre') && !empty($request->get('titre'))){
            $productsList->setName($request->get('titre'));
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
