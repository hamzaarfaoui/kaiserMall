<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommandesController extends Controller
{
	public function listAction(Request $request)
	{
		$dm = $this->getDoctrine()->getManager();
		$find_commandes = $dm->getRepository('App:Factures')->liste();
        $commandes_liste = array();
        foreach ($find_commandes as $k=>$row) {
            $products = explode(' , ', $row['products']);
            $commandes_liste[$k]['id'] = $row['id'];
            $commandes_liste[$k]['marchand'] = $row['marchand'];
            $commandes_liste[$k]['nom'] = $row['nom'];
            $commandes_liste[$k]['prenom'] = $row['prenom'];
            $commandes_liste[$k]['adress'] = $row['adress'];
            $commandes_liste[$k]['phone'] = $row['phone'];
            $commandes_liste[$k]['products'] = $products;
            $commandes_liste[$k]['qte'] = $row['qte'];
            $commandes_liste[$k]['price'] = $row['price'];
        }
        $paginator  = $this->get('knp_paginator');
        $commandes = $paginator->paginate(
            $commandes_liste, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $commandes->setTemplate('commandes/back/pagination.html.twig');
		return $this->render('commandes/back/list.html.twig',array('commandes' => $commandes));
	}
	public function statistiquesAction(Request $request)
	{
		$dm = $this->getDoctrine()->getManager();
		$params = array('this_year' => true);
		$commandes = $dm->getRepository('App:Factures')->listeInDash($params);
		 $categories = $dm->getRepository('App:CategoriesMere')->liste();
        $commandes_chart = "";
        $months = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Séptembre', 10 => 'octobre', 11 => 'Novembre', 12 => 'Décembre'];
        foreach ($commandes as $key => $commande) {
            $commandes_chart .= "['".$months[$commande['date_cmd']]."', ".intval($commande['nb_cmd'])."],";
        }
        $deb = date("d-m-Y");
        $fin = date("d-m-Y");
        return $this->render('commandes/back/stats.html.twig',array(
            'commandes' => $commandes_chart,
            'categories' => $categories,
            'deb' => $deb,
            'fin' => $fin,
            'months' => $months
        ));
	}
}