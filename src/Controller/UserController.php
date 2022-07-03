<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /*
     * Dashboard
     */
    public function dashboard()
    {
        $dm = $this->getDoctrine()->getManager();
        $params = array('this_year' => true);
        $commandes = $dm->getRepository('App:Commandes')->listeInDash($params);
        $commandes_chart = "";
        $months = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Séptembre', 10 => 'octobre', 11 => 'Novembre', 12 => 'Décembre'];
        foreach ($commandes as $key => $commande) {
            $commandes_chart .= "['".$months[$commande['date_cmd']]."', ".intval($commande['nb_cmd'])."],";
        }
        $nombreCmdValide = $dm->getRepository('App:Commandes')->nombreCmdValide();
        $nombreCmdEnCours = $dm->getRepository('App:Commandes')->nombreCmdEnCours();
        $deb = date("d-m-Y");
        $fin = date("d-m-Y");
        return $this->render('user/espaces/admin.html.twig',array(
            'nombre_commandes_valide' => $nombreCmdValide,
            'nombre_commandes_en_cours' => $nombreCmdEnCours,
            'commandes' => $commandes_chart,
            'deb' => $deb,
            'fin' => $fin,
            'months' => $months
        ));
    }

    /*
    * filterCommandes
    */
    public function filterCommandes(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $filter = $request->get('filter') == "this_year" ? array('this_year' => true) : ['month' => $request->get('filter')];
        $commandes = $dm->getRepository('App:Commandes')->listeInDash($filter);
        $commandes_chart = array(['Price', 'Commandes']);
        if($request->get('filter') == "this_year"){
            $months = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Séptembre', 10 => 'octobre', 11 => 'Novembre', 12 => 'Décembre'];
            foreach ($commandes as $key => $commande) {
                $commandes_chart[] = [$months[$commande['date_cmd']], intval($commande['nb_cmd'])];
            }
        }else{
            foreach ($commandes as $key => $commande) {
                $commandes_chart[] = [$commande['date_cmd'], intval($commande['nb_cmd'])];
            }
        }
        return new JsonResponse(array('result' => $commandes_chart));
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
