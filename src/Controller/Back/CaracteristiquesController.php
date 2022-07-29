<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Caracteristiques;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class CaracteristiquesController extends Controller
{
    /*
     * caracteristiques list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findAll();
        $categoriesMere = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('Products/back/caracteristiques/list.html.twig', array(
            'categoriesMere' => $categoriesMere,
            'caracteristiques' => $caracteristiques
        ));
    }
    
    /*
     * caracteristique details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $caracteristique = $dm->getRepository('App:Caracteristiques')->find($id);
        return $this->render('Products/back/caracteristiques/details.html.twig', array('caracteristique' => $caracteristique));
    }
    
    /*
     * New caracteristique
     */
    public function newAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $caracteristique = new Caracteristiques();
        $caracteristique->setName($request->get('nom'));
        $caracteristique->setCode($request->get('code'));
        $categorie = $dm->getRepository('App:SousCategories')->find($request->get('categorie'));
        $caracteristique->setSousCategorie($categorie);
        $dm->persist($caracteristique);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Caracteristique ".$caracteristique->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_caracteristiques_index');
    }
    
    /*
     * caracteristique edit
     */
    public function editAction($id, Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $caracteristique = $dm->getRepository('App:Caracteristiques')->find($id);
        $caracteristique->setName($request->get('nom'));
        $dm->persist($caracteristique);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Caracteristique ".$caracteristique->getName()." a été mis à jour");

        return $this->redirectToRoute('dashboard_caracteristiques_index');
    }
    
    
    
    /*
     * Delete caracteristique
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $caracteristique = $dm->getRepository('App:Caracteristiques')->find($id);
        $dm->remove($caracteristique);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Caracteristique ".$caracteristique->getName()." supprimée");
        return $this->redirectToRoute('dashboard_caracteristiques_index');
    }
}
