<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\SousCategories;
use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Entity\Products;

class SousCategories2Controller extends Controller
{
    
    /*
     * Categories list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $categories = $dm->getRepository('App:SousCategories')->findAll();
        return $this->render('categories/sc2/list.html.twig', array('categories' => $categories));
    }
    
    /*
     * Categories gréffer à la page d'acceuil 
     */
    public function grefferAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $categories = $dm->getRepository('App:SousCategories')->findAll();
        $categoriesInIndex = $dm->getRepository('App:SousCategories')->findBy(array('showInIndex' => 1));
        return $this->render('categories/sc2/greffer.html.twig', array('categories' => $categories, 'categoriesInIndex' => $categoriesInIndex));
    }
    
    /*
     * Ajouter une catégorie à l'acceuil 
     */
    public function addCategorieOnIndexAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        
        $listItem = $request->request->get('listItem');
        $limit = $request->request->get('limit');
        $page = $request->request->get('page');
        $count = 1;

        foreach ($listItem as $item) {
            $position = (($page - 1) * $limit) + $count;
            $sc = $dm->getRepository('App:SousCategories')->find($item);
            $sc->setOrderInIndex($position);
            $dm->persist($sc);
            $sc->setShowInIndex(1);
            $dm->persist($sc);
            $count++;
        }
        
        $dm->flush();
        return new JsonResponse(array(
            'message' => $listItem,'limit' => $limit,
            'page' => $page));
    }
    
    /*
     * Retirer une catégorie de l'acceuil 
     */
    public function removeCategorieFromIndexAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $sc = $dm->getRepository('App:SousCategories')->find($id);
        $sc->setShowInIndex(0);
        $dm->persist($sc);
        $dm->flush();
        return new JsonResponse(array('message' => 'La catégorie '.$sc->getName().' a été retiré de l\'acceuil'));
    }
    
    /*
     * Souscategories2 by sc1
     */
    public function Souscategories2bysc1($sc1)
    {
        $dm = $this->getDoctrine()->getManager();
        $sc = $dm->getRepository('App:Categories')->find($sc1);
        $categories = $dm->getRepository('App:SousCategories')->findBy(array('categorie' => $sc));
        $options = '<option value="">Sélectionner une catégorie</option>';
        foreach ($categories as $categorie){
            $options .= '<option value="'.$categorie->getId().'">'.$categorie->getName().'</option>';
        }
        return new JsonResponse(['status'=>'ok', 'options'=>$options]);
    }
    
    /*
     * sousCategorie2 details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        $products = $dm->getRepository('App:Products')->findBy(array('sousCategorie' => $categorie), array('position' => 'ASC'));
        return $this->render('categories/sc2/show.html.twig', array(
            'categorie' => $categorie,
            'products' => $products
                ));
    }
    
    /*
     * sousCategorie2 show products banners in index
     */
    public function showProductsBannersInIndexAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        $message = '';
        if($categorie->getHasBanner() == 1){
            $categorie->setHasBanner(0);
            $message .= 'L\'affichage des banniéres des produits est désactivé';
        }else{
            $categorie->setHasBanner(1);
            $message .= 'L\'affichage des banniéres des produits est activé';
        }
        $dm->persist($categorie);
        $dm->flush();
        return new JsonResponse(array('message' => $message));
    }
    
    /*
     * New sousCategorie2 page
     */
    public function newAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:Categories')->find($id);
       return $this->render('categories/sc2/new.html.twig', array('categorie' => $categorie));
    }
    
    /*
     * New sousCategorie2 traitement
     */
    public function newTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $sc = $dm->getRepository('App:Categories')->find($id);
        //dump($sc);die();
        $categorie = new SousCategories();
        $categorie->setName($request->get('nom'));
        $categorie->setContent($request->get('descriptionC'));
        $categorie->setCreatedAt(new \DateTime('now'));
        $categorie->setCategorie($sc);
        if (isset($_FILES["couvertureC"]) && !empty($_FILES["couvertureC"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_categories_sc2') . "/" . $fileName
            );
            $categorie->setImage($fileName);
        }
        if (isset($_FILES["iconeC"]) && !empty($_FILES["iconeC"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_categories_sc2') . "/" . $fileName
            );
            $categorie->setIcone($fileName);
        }
        $dm->persist($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La sous catégorie ".$categorie->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_sc2_details', array('id' => $categorie->getId()));
    }
    
    /*
     * sousCategorie2 edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        return $this->render('categories/sc2/edit.html.twig', array('categorie' => $categorie));
    }
    
    /*
     * sousCategorie2 edit traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        $categorie->setName($request->get('nom'));
        $categorie->setContent($request->get('descriptionC'));
        $categorie->setCreatedAt(new \DateTime('now'));
        if (isset($_FILES["couvertureC"]["name"]) && !empty($_FILES["couvertureC"]["name"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_categories_sc2') . "/" . $fileName
            );
            $categorie->setImage($fileName);
        }else{
            $categorie->setImage($categorie->getImage());
        }
        if (isset($_FILES["iconeC"]["name"]) && !empty($_FILES["iconeC"]["name"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_categories_sc2') . "/" . $fileName
            );
            $categorie->setIcone($fileName);
        }else{
            $categorie->setIcone($categorie->getIcone());
        }
        $dm->persist($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La sous catégorie ".$categorie->getName()." a été mis à jour");
        return $this->redirectToRoute('dashboard_sc2_details', array('id' => $categorie->getId()));
    }
    
    /*
     * Delete categorieMere
     */
    public function deleteAction(Request $request, $id, $c)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_categories_sc2')."/".$categorie->getImage(), ''.$categorie->getImage().''));
        $fileSystem->remove(array('symlink', $this->getParameter('images_categories_sc2')."/".$categorie->getIcone(), ''.$categorie->getIcone().''));
        $dm->remove($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La catégorie ".$categorie->getName()." supprimée");
        return $this->redirectToRoute('dashboard_sc1_details', array('id' => $categorie->getCategorie()->getId()));
    }
}
