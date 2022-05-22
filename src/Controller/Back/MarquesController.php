<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Marques;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MarquesController extends Controller
{
    /*
     * Marques list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $marques = $dm->getRepository('App:Marques')->findAll();
        return $this->render('marques/list.html.twig', array('marques' => $marques));
    }
    
    /*
     * Marque details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        return $this->render('marques/show.html.twig', array('marque' => $marque));
    }
    
    /*
     * New Marque page
     */
    public function newAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $categories = $dm->getRepository('App:SousCategories')->findAll();
        return $this->render('marques/new.html.twig', array('categories' => $categories));
    }
    
    /*
     * Marques by categorie
     */
    public function marquesByCategorieAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        $marques = $dm->getRepository('App:Marques')->findBy(array('sousCategorie' => $categorie));
        $options = '<option value="">Sélectionner une marque</option>';
        foreach ($marques as $marque){
            $options .= '<option value="'.$marque->getId().'">'.$marque->getName().'</option>';
        }
        return new JsonResponse(['status'=>'ok', 'options'=>$options]);
    }
    
    /*
     * New marque traitement
     */
    public function newTraitementAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = new Marques();
        $marque->setName($request->get('nom'));
        $marque->setContent($request->get('descriptionC'));
        $marque->setCreatedAt(new \DateTime('now'));
        $marque->setVideo($request->get('video'));
        $categorie_id = $request->get('categorie');
        $categorie = $dm->getRepository('App:SousCategories')->find($categorie_id);
        $marque->setSousCategorie($categorie);
        if (isset($_FILES["image"]) && !empty($_FILES["image"])) {
            $file = $_FILES["image"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["image"]["tmp_name"], $this->getParameter('images_marques') . "/" . $fileName
            );
            $marque->setImage($fileName);
        }
        $dm->persist($marque);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La marque ".$marque->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_marques_back_details', array('id' => $marque->getId()));
    }
    
    /*
     * Marque edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        $categories = $dm->getRepository('App:SousCategories')->findAll();
        return $this->render('marques/edit.html.twig', array('marque' => $marque, 'categories' => $categories));
    }
    
    /*
     * Edit Marque traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        $marque->setName($request->get('nom'));
        $marque->setContent($request->get('description'));
        $marque->setVideo($request->get('video'));
        $marque->setUpdatedAt(new \DateTime('now'));
        $categorie_id = $request->get('categorie');
        $categorie = $dm->getRepository('App:SousCategories')->find($categorie_id);
        $marque->setSousCategorie($categorie);
        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            $file = $_FILES["image"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["image"]["tmp_name"], $this->getParameter('images_marques') . "/" . $fileName
            );
            $marque->setImage($fileName);
        }
        
        $dm->persist($marque);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La marque ".$marque->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_marques_back_details', array('id' => $marque->getId()));
    }
    
    /*
     * Delete Marque
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $marque = $dm->getRepository('App:CategoriesMere')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_marques')."/".$marque->getImage(), ''.$marque->getImage().''));
        $dm->remove($marque);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La marque ".$marque->getName()." supprimée");
        return $this->redirectToRoute('dashboard_marques_back_index');
    }
}
