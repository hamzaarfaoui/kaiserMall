<?php

namespace App\Controller\Front\Marchand;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Favoris;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\AdressesStore;
use App\Entity\TelephonesStore;

class CommandesController extends Controller
{
    /*
     * store Commandes list
     */
    public function listCommandes()
    {
        $dm = $this->getDoctrine()->getManager();
        $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()));
        if(!$marchand){
          $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()->getOwner()));  
        }
        
        $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
        $id = $store->getId();
        $params = array('this_year' => true);
        $commandes = $dm->getRepository('App:Commandes')->listeInDash($params);
        $commandes_liste = array();
        foreach ($commandes as $commande){
            foreach ($commande['facture']['products'] as $facture){
                if($facture['id_vendeur'] == $id){
                    if(!in_array($commande, $commandes_liste)){
                        $commandes_liste [] = $commande;
                    }
                    
                }
            }
        }

        $list = array();
        
        foreach ($commandes_liste as $c){
            $montant = 0;
            foreach ($c['facture']['products'] as $f){
                if($f['id_vendeur'] == $id){
                    $montant += $f['price']*$f['quantite'];
                }
            }
            $list [] = array(
                'id'=>$c['id'],
                'client'=>$c['facture']['client']['nom_prenom'],
                'montant' => $montant,
                'date' => $c['date_cmd'],
                'status' => $c['status']
            );
        }
        return $this->render('commandes/marchand/index.html.twig', array('commandes' => $list, 'store' => $id));
    }
    
    /*
     * store Commandes list in dashbord
     */
    public function listCommandesInDash($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $params = array('this_year' => true);
        $commandes = $dm->getRepository('App:Commandes')->listeInDash($params);
        $commandes_liste = array();
        //dump($commandes);die();
        foreach ($commandes as $commande){
            foreach ($commande['facture']['products'] as $facture){
                if($facture['id_vendeur'] == $id){
                    if(!in_array($commande, $commandes_liste)){
                        $commandes_liste [] = $commande;
                    }
                    
                }
            }
        }

        $list = array();
        
        foreach ($commandes_liste as $c){
            $montant = 0;
            foreach ($c['facture']['products'] as $f){
                if($f['id_vendeur'] == $id){
                    $montant += $f['price']*$f['quantite'];
                }
            }
            $list [] = array(
                'id'=>$c['id'],
                'client'=>$c['facture']['client']['nom_prenom'],
                'montant' => $montant,
                'date' => $c['date_cmd'],
                'status' => $c['status']
            );
        }
        return $this->render('commandes/marchand/dash.html.twig', array('commandes' => $list, 'store' => $id));
    }
    
    /*
     * store Commande details
     */
    public function showAction($id, $store)
    {
        $dm = $this->getDoctrine()->getManager();
        $commande = $dm->getRepository('App:Commandes')->find($id);
        $products = array();
        $err_cmd = false;
        foreach ($commande->getFacture()['products'] as $facture){
            if($facture['id_vendeur'] == $store){
                if(!in_array($commande, $products)){
                    $products [] = $facture;
                }

            }else{
                $err_cmd = true;
            }
        }
        if($err_cmd){
            return $this->redirect($this->generateUrl('marchand_commandes_index'));
        }
        $montant = 0;
        foreach ($commande->getFacture()['products'] as $f){
            if($f['id_vendeur'] == $store){
                $montant += $f['price']*$f['quantite'];
            }
        }
        return $this->render('commandes/marchand/show.html.twig', array(
            'commande' => $commande,
            'products' => $products,
            'montant' => $montant,
            'date' => $commande->getCreatedAt(),
            'client'=>$commande->getFacture()['client']['nom_prenom'],
            'store' => $store
            ));
    }
    
    /*
     * store Commande validate
     */
    public function validateAction(Request $request,$id, $store)
    {
        $dm = $this->getDoctrine()->getManager();
        $commande = $dm->getRepository('App:Commandes')->find($id);
        $products = array();
        foreach ($commande->getFacture()['products'] as $facture){
            if($facture['id_vendeur'] == $store){
                if(!in_array($commande, $products)){
                    $product = $dm->getRepository('App:Products')->find($facture['id']);
                    $product->setQte($product->getQte()-$facture['quantite']);
                    $products [] = $facture;
                }

            }
        }
        $montant = 0;
        foreach ($commande->getFacture()['products'] as $f){
            if($f['id_vendeur'] == $store){
                $montant += $f['price']*$f['quantite'];
            }
        }
        $commande->setStatus(2);
        $dm->persist($commande);
        $dm->flush();
        return $this->redirectToRoute('marchand_commandes_details', array('id' => $id, 'store' => $store));
    }
    
    /*
     * store Commandes list
     */
    public function valider($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marchand = $dm->getRepository('App:Marchands')->find($id);
        $stores = $dm->getRepository('App:Stores')->findBy(array('marchand' => $marchand));
        return $this->render('marchand/storesList.html.twig', array('stores' => $stores));
    }
}
