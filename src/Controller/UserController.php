<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;

class UserController extends Controller
{
    /*
     * Dashboard
     */
    public function dashboard()
    {
        $dm = $this->getDoctrine()->getManager();
        $nombreCmdValide = $dm->getRepository('App:Commandes')->nombreCmdValide();
        $nombreCmdEnCours = $dm->getRepository('App:Commandes')->nombreCmdEnCours();
        $deb = date("d-m-Y");
        $fin = date("d-m-Y");
        return $this->render('user/espaces/admin.html.twig',array(
            'nombre_commandes_valide' => $nombreCmdValide,
            'nombre_commandes_en_cours' => $nombreCmdEnCours,
            'deb' => $deb,
            'fin' => $fin
        ));
    }
    
    /*
     * Employe
     */
    public function employe()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('user/espaces/employe.html.twig');
    }
    
    /*
     * Marchand
     */
    public function marchand()
    {
        $dm = $this->getDoctrine()->getManager();
        if(in_array('ROLE_MARCHAND', $this->getUser()->getRoles(), true)){
            $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()));
            $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
            return $this->render('user/espaces/marchand.html.twig',array('store' => $store));
        }else{
            $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()->getOwner()));
            $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
            return $this->redirectToRoute('marchand_product_index', array('id' => $store->getId()));
        }
        
        
    }
    
    /*
     * client
     */
    public function client()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('user/espaces/client.html.twig');
    }
}
