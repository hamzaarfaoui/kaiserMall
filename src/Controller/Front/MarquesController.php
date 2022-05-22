<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Marques;

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
     * Marque edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        return $this->render('marques/edit.html.twig', array('marque' => $marque));
    }
}
