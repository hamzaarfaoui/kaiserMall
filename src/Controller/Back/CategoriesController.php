<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\CategoriesMere;
use App\Entity\Categories;
use App\Entity\SousCategories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class CategoriesController extends Controller
{
    /*
     * Categories list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $categoriesMere = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('categories/cm/list.html.twig', array('categoriesMere' => $categoriesMere));
    }
    
    /*
     * CategorieMere details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:CategoriesMere')->find($id);
        $scs = $dm->getRepository('App:Categories')->findBy(array('categorieMere' => $categorie));
        return $this->render('categories/cm/show.html.twig', array('categorie' => $categorie,
            'scs' => $scs
    ));
    }
    
    /*
     * New CategorieMere page
     */
    public function newAction()
    {
        return $this->render('categories/cm/new.html.twig');
    }
    
    /*
     * New CategorieMere traitement
     */
    public function newTraitementAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $categoriesMere = new CategoriesMere();
        $categoriesMere->setName($request->get('nom'));
        $categoriesMere->setContent($request->get('descriptionC'));
        $categoriesMere->setCreatedAt(new \DateTime('now'));
        if (isset($_FILES["couvertureC"]) && !empty($_FILES["couvertureC"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_categories_cm') . "/" . $fileName
            );
            $categoriesMere->setImage($fileName);
        }
        if (isset($_FILES["iconeC"]) && !empty($_FILES["iconeC"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_categories_cm') . "/" . $fileName
            );
            $categoriesMere->setIcone($fileName);
        }
        $dm->persist($categoriesMere);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La catégorie ".$categoriesMere->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_categories_details', array('id' => $categoriesMere->getId()));
    }
    
    /*
     * CategorieMere edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:CategoriesMere')->find($id);
        return $this->render('categories/cm/edit.html.twig', array('categorie' => $categorie));
    }
    
    /*
     * CategorieMere edit traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categoriesMere = $dm->getRepository('App:CategoriesMere')->find($id);
        $categoriesMere->setName($request->get('nom'));
        $categoriesMere->setContent($request->get('descriptionC'));
        $categoriesMere->setUpdatedAt(new \DateTime('now'));
        if (isset($_FILES["couvertureC"]["name"]) && !empty($_FILES["couvertureC"]["name"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_categories_cm') . "/" . $fileName
            );
            $categoriesMere->setImage($fileName);
        }else{
            $categoriesMere->setImage($categoriesMere->getImage());
        }
        if (isset($_FILES["iconeC"]["name"]) && !empty($_FILES["iconeC"]["name"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_categories_cm') . "/" . $fileName
            );
            $categoriesMere->setIcone($fileName);
        }else{
            $categoriesMere->setIcone($categoriesMere->getIcone());
        }
        $dm->persist($categoriesMere);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La catégorie ".$categoriesMere->getName()." a été mis à jour");
        return $this->redirectToRoute('dashboard_categories_details', array('id' => $categoriesMere->getId()));
    }
    
    /*
     * Delete categorieMere
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $categorie = $dm->getRepository('App:CategoriesMere')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_categories_cm')."/".$categorie->getImage(), ''.$categorie->getImage().''));
        $fileSystem->remove(array('symlink', $this->getParameter('images_categories_cm')."/".$categorie->getIcone(), ''.$categorie->getIcone().''));
        $dm->remove($categorie);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La catégorie ".$categorie->getName()." supprimée");
        return $this->redirectToRoute('dashboard_categories_index');
    }
}
