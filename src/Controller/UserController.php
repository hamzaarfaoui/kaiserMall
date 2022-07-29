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
        $commandes_no_valides_query = $dm->getRepository('App:Factures')->listeNoValideInDash();
        $commandes_no_valides = array();
        foreach ($commandes_no_valides_query as $k=>$row) {
            $products = explode(' , ', $row['products']);
            $commandes_no_valides[$k]['id'] = $row['id'];
            $commandes_no_valides[$k]['marchand'] = $row['marchand'];
            $commandes_no_valides[$k]['nom'] = $row['nom'];
            $commandes_no_valides[$k]['prenom'] = $row['prenom'];
            $commandes_no_valides[$k]['adress'] = $row['adress'];
            $commandes_no_valides[$k]['phone'] = $row['phone'];
            $commandes_no_valides[$k]['products'] = $products;
            $commandes_no_valides[$k]['qte'] = $row['qte'];
            $commandes_no_valides[$k]['price'] = $row['price'];
        }
        $params = array('this_year' => true);
        $revenus = $dm->getRepository('App:Stores')->listeInDash($params);
        $revenus_chart = "";
        $revenus_table = array();
        $months = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Séptembre', 10 => 'octobre', 11 => 'Novembre', 12 => 'Décembre'];
        foreach ($revenus as $key => $revenu) {
            if(array_key_exists($revenu['date_offre'], $months)){
                $revenus_table[] = [$months[$revenu['date_offre']], intval($revenu['total_offre'])];
                $revenus_chart .= "['".$months[$revenu['date_offre']]."', ".intval($revenu['total_offre'])."],";
            }else{
                $revenus_chart .= "['".$months[$revenu['date_offre']]."', 0],";
                $revenus_table[] = [$months[$revenu['date_offre']],0];
            }
        }
        $deb = date("d-m-Y");
        $fin = date("d-m-Y");
        return $this->render('user/espaces/admin.html.twig',array(
            'commandes_no_valides' => $commandes_no_valides,
            'revenus_chart' => $revenus_chart,
            'revenus_table' => $revenus_table,
            'deb' => $deb,
            'fin' => $fin,
            'months' => $months
        ));
    }

    public function validateCommande(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $commande = $dm->getRepository('App:Commandes')->find($id);
        $commande->setStatus(2);
        $dm->persist($commande);
        $dm->flush();
        return new JsonResponse(array('message' => 'Commande validée'));
    }

    /*
    * filter revenu
    */
    public function filterRevenu(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $filter = $request->get('period') == "this_year" ? array('this_year' => true) : ['month' => $request->get('period')];
        $revenus = $dm->getRepository('App:Stores')->listeInDash($filter);
        $revenus_chart = array(['Période', 'Revenu']);
        $months = ['1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août', '9' => 'Séptembre', '10' => 'octobre', '11' => 'Novembre', '12' => 'Décembre'];
        
        $entity = "";
        if($request->get('period') == "this_year"){
            $entity = "Mois";
            foreach ($revenus as $key => $revenu) {
                $revenus_chart[] = [$months[$revenu['date_offre']], intval($revenu['total_offre'])];
            }
        }
        if($request->get('period') != "this_year"){
            $entity = $months[$filter['month']];
            foreach ($revenus as $key => $revenu) {
                $revenus_chart[] = [$revenu['date_offre'], intval($revenu['total_offre'])];
            }
        }
        return new JsonResponse(array('revenus' => $revenus_chart, 'entity' => $entity));
    }

    /*
    * filterCommandes
    */
    public function filterCommandes(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $filter = $request->get('period') == "this_year" ? array('this_year' => true) : ['month' => $request->get('period')];
        $filter['bymarchand'] = $request->get('bymarchand') == 'true' ? true : false;
        $filter['bycategory'] = $request->get('bycategory') == 'true' ? true : false;
        $filter['categoriesMere'] = $request->get('categoriesMere') != 0 ? $request->get('categoriesMere') : false;
        $filter['sousCategory'] = $request->get('sousCategory') != 0 ? $request->get('sousCategory') : false;
        $table = array();
        $commandes = $dm->getRepository('App:Factures')->listeInDash($filter);
        $commandes_chart = array(['Price', 'Commandes']);
        $months = ['1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août', '9' => 'Séptembre', '10' => 'octobre', '11' => 'Novembre', '12' => 'Décembre'];
        
        $entity = "";
        if($request->get('period') == "this_year" && $request->get('bymarchand') == 'false' && $request->get('bycategory') == 'false'){
            $entity = "Mois";
            $commandes_chart = array(['Mois', 'Commandes']);
            $table = array(['Mois', 'Comandes']);
            foreach ($commandes as $key => $commande) {
                $table[] = [$months[$commande['date_cmd']], intval($commande['nb_cmd'])];
                $commandes_chart[] = [$months[$commande['date_cmd']], intval($commande['nb_cmd'])];
            }
        }
        if($request->get('period') != "this_year" && $request->get('bymarchand') == 'false' && $request->get('bycategory') == 'false'){
            $entity = $months[$filter['month']];
            $commandes_chart = array(['Jour', 'Commandes']);
            $table = array(['Jour', 'Comandes']);
            foreach ($commandes as $key => $commande) {
                $commandes_chart[] = [$commande['date_cmd'], intval($commande['nb_cmd'])];
            }
        }
        if($request->get('bymarchand') == 'true' && $request->get('bycategory') == 'false'){
            $entity = 'Marchands';
            $commandes_chart = array(['Marchand', 'Commandes']);
            $i = 0;
            $table = array(['Marchand', 'Comandes']);
            foreach ($commandes as $key => $commande) {
                $table[] = [$commande['marchand'], intval($commande['nb_cmd'])];
                if($i < 21){
                    $commandes_chart[] = [$commande['marchand'], intval($commande['nb_cmd'])];
                }
                $i++;
            }
        }
        if($request->get('bymarchand') == 'false' && $request->get('bycategory') == 'true'){
            $entity = 'Categories';
            $commandes_chart = array(['Categorie', 'Commandes']);
            $table = array(['Categorie', 'Comandes']);
            foreach ($commandes as $key => $commande) {
                $table[] = [$commande['categorie'], intval($commande['nb_cmd'])];
                $commandes_chart[] = [$commande['categorie'], intval($commande['nb_cmd'])];
            }
        }
        return new JsonResponse(array('commandes' => $commandes_chart, 'entity' => $entity, 'table' => $table));
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
