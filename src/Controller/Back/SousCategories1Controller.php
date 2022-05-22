<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Categories;
use App\Entity\SousCategories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class SousCategories1Controller extends Controller
{
    /*
     * Categories list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $categories = $dm->getRepository('App:Categories')->findAll();
        return $this->render('categories/sc1/list.html.twig', array('categories' => $categories));
    }
    /*
     * Souscategories1 by CM
     */
    public function Souscategories1bycm($cm)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorieMere = $dm->getRepository('App:CategoriesMere')->find($cm);
        $categories = $dm->getRepository('App:Categories')->findBy(array('categorieMere' => $categorieMere));
        $options = '<option value="">Sélectionner une catégorie</option>';
        foreach ($categories as $categorie){
            $options .= '<option value="'.$categorie->getId().'">'.$categorie->getName().'</option>';
        }
        return new JsonResponse(['status'=>'ok', 'options'=>$options]);
    }
    
    /*
     * CategorieMere details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:Categories')->find($id);
        return $this->render('categories/sc1/show.html.twig', array('categorie' => $categorie));
    }
    
    /*
     * New CategorieMere page
     */
    public function newAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:CategoriesMere')->find($id);
        $cms = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('categories/sc1/new.html.twig',array('categorie' => $categorie, 'cms' => $cms));
    }
    
    /*
     * New CategorieMere traitement
     */
    public function newTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = new Categories();
        $categorie->setName($request->get('nom'));
        $categorie->setContent($request->get('descriptionC'));
        $categorie->setCreatedAt(new \DateTime('now'));
        $cm = $dm->getRepository('App:CategoriesMere')->find($id);
        
        $categorie->setCategorieMere($cm);
        if (isset($_FILES["couvertureC"]) && !empty($_FILES["couvertureC"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_categories_sc1') . "/" . $fileName
            );
            $categorie->setImage($fileName);
        }
        if (isset($_FILES["iconeC"]) && !empty($_FILES["iconeC"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_categories_sc1') . "/" . $fileName
            );
            $categorie->setIcone($fileName);
        }
        $dm->persist($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La sous catégorie ".$categorie->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_sc1_details', array('id' => $categorie->getId()));
    }
    
    /*
     * CategorieMere edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:Categories')->find($id);
        $cms = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('categories/sc1/edit.html.twig', array('categorie' => $categorie, 'cms' => $cms));
    }
    
    /*
     * CategorieMere edit traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:Categories')->find($id);
        $categorie->setName($request->get('nom'));
        $categorie->setContent($request->get('descriptionC'));
        $categorie->setCreatedAt(new \DateTime('now'));
        $cm = $dm->getRepository('App:CategoriesMere')->find($request->get('cm'));
        
        $categorie->setCategorieMere($cm);
        
        if (isset($_FILES["couvertureC"]["name"]) && !empty($_FILES["couvertureC"]["name"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_categories_sc1') . "/" . $fileName
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
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_categories_sc1') . "/" . $fileName
            );
            $categorie->setIcone($fileName);
        }else{
            $categorie->setIcone($categorie->getIcone());
        }
        $dm->persist($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La sous catégorie ".$categorie->getName()." a été mis à jour");
        return $this->redirectToRoute('dashboard_sc1_details', array('id' => $categorie->getId()));
    }
    
    /*
     * Delete categorieMere
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $categorie = $dm->getRepository('App:Categories')->find($id);
        $cm = $dm->getRepository('App:CategoriesMere')->find($categorie->getCategorieMere());
        $fileSystem->remove(array('symlink', $this->getParameter('images_categories_sc1')."/".$categorie->getImage(), ''.$categorie->getImage().''));
        $fileSystem->remove(array('symlink', $this->getParameter('images_categories_sc1')."/".$categorie->getIcone(), ''.$categorie->getIcone().''));
        $dm->remove($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La sous catégorie ".$categorie->getName()." supprimée");
        return $this->redirectToRoute('dashboard_categories_details', array('id' => $cm->getId()));
    }
}
