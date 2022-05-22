<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Valeurs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class ValeursController extends Controller
{
    /*
     * valeurs list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $valeurs = $dm->getRepository('App:Valeurs')->findAll();
        return $this->render('Products/back/valeurs/list.html.twig', array('valeurs' => $valeurs));
    }
    
    /*
     * valeur details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $valeur = $dm->getRepository('App:Valeurs')->find($id);
        return $this->render('Products/back/valeurs/details.html.twig', array('valeur' => $valeur));
    }
    
    /*
     * New valeur
     */
    public function newAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $caracteristique = $dm->getRepository('App:Caracteristiques')->find($id);
        $valeur = new Valeurs();
        $valeur->setName($request->get('nom'));
        $valeur->setCaracteristique($caracteristique);
        $dm->persist($valeur);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Valeur ".$valeur->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_caracteristiques_details', array('id' => $caracteristique->getId()));
    }
    
    /*
     * valeur edit
     */
    public function editAction($id, Request $request, $c)
    {
        $dm = $this->getDoctrine()->getManager();
        $valeur = $dm->getRepository('App:Valeurs')->find($id);
        $caracteristique = $dm->getRepository('App:Caracteristiques')->find($c);
        $valeur->setName($request->get('nom'));
        $dm->persist($valeur);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Valeur ".$valeur->getName()." a été mis à jour");
        return $this->redirectToRoute('dashboard_caracteristiques_details', array('id' => $caracteristique->getId()));
    }
    
    
    
    /*
     * Delete valeur
     */
    public function deleteAction(Request $request, $id,$c)
    {
        $dm = $this->getDoctrine()->getManager();
        $valeur = $dm->getRepository('App:Valeurs')->find($id);
        $caracteristique = $dm->getRepository('App:Caracteristiques')->find($c);
        $dm->remove($valeur);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Valeur ".$valeur->getName()." supprimée");
        return $this->redirectToRoute('dashboard_caracteristiques_details', array('id' => $caracteristique->getId()));
    }
}
