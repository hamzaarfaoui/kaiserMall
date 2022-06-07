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
    public function showInFront(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $slider = $dm->getRepository('App:Banners')->find($id);
        $products_liste = array();
        $produit = $slider->getProduct();
        $categorie = $produit->getSousCategorie();
        $products = $dm->getRepository('App:Products')->liees($categorie);
        foreach ($products as $p){
            if($p->getId()!=$produit->getId()){
                $products_liste[] = $p;
            }
        }
        $paginator  = $this->get('knp_paginator');
        $products_liste = $paginator->paginate(
            $products_liste, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            20 /*limit per page*/
        );
        $find_products = $dm->getRepository('App:Products')->findBy(array('sousCategorie' => $categorie));
        $products_price = array();
        foreach ($find_products as $product) {
            $products_price[] = $product->getPricePromotion()?$product->getPricePromotion():$product->getPrice();
        }
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findBy(array('sousCategorie' => $categorie));
        $couleurs = $dm->getRepository('App:Products')->couleursProductsBycategories($categorie);
        $marques = $dm->getRepository('App:Marques')->findBy(array('sousCategorie' => $categorie));
        $min = count($products_price) > 0 ? min($products_price) : 0;
        $max = count($products_price) > 0 ? max($products_price) : 0;
        return $this->render('Banners/front/detailsFront.html.twig', array('product' => $produit, 'products' => $products_liste, 'categorie' => $categorie,'min' => $min, 'couleurs' => $couleurs,'caracteristiques' => $caracteristiques,'max'=>$max, 'marques'=>$marques));
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
            $productsList = new ProductsList();
            if($request->get('titre') && !empty($request->get('titre'))){
                $productsList->setName($request->get('titre'));
            }
            $productsList->setBanner($banner);
            $dm->persist($productsList);
            $dm->persist($banner);
            $dm->flush();
            $request->getSession()->getFlashBag()->add('success', "La banniére a été ajoutée");
        }
        return $this->redirectToRoute('dashboard_banners_details', array('id' => $banner->getId()));
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
        if($request->get('titre') && !empty($request->get('titre'))){
            $productsList = $banner->getProductsList();
            $productsList->setName($request->get('titre'));
        }
        $dm->persist($banner);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La banniére a été modifiée");
        
        return $this->redirectToRoute('dashboard_banners_index');
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
