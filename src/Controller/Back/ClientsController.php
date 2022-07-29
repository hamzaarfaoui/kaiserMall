<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClientsController extends Controller
{
	public function listAction(Request $request)
	{
		$dm = $this->getDoctrine()->getManager();
		$find_clients = $dm->getRepository('App:Factures')->listeByRole('ROLE_CLIENT');
        $paginator  = $this->get('knp_paginator');
        $clients = $paginator->paginate(
            $find_clients, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            30 /*limit per page*/
        );
        $clients->setTemplate('clients/pagination.html.twig');
		return $this->render('clients/list.html.twig',array('clients' => $clients));
	}
    public function showAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $commande = $dm->getRepository('App:Factures')->oneElement($id);
        return $this->render('clients/show.html.twig',array('commande' => $commande));
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