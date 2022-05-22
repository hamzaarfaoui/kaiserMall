<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commandes;
use Symfony\Component\HttpFoundation\Response;

class CommandesController extends Controller
{
    public function facture(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $total = 0;
        //$totalTTC = 0;
        
        //$livraison = $dm->getRepository('EcommerceBundle:Adresses')->find($adresse['livraison']);
        $products = $dm->getRepository('App:Products')->findArray(array_keys($session->get('panier')));
        
        foreach($products as $product)
        {
            $prix = $product->getPricePromotion()?$product->getPricePromotion():$product->getPrice() ;
            //$prixTTC = ($product->getPrixunitaireht() * $panier[$product->getId()] / $product->getTva()->getMultiplicate());
            $total += $prix * $panier[$product->getId()];
            //$totalTTC += $prixTTC;
            
//            if (!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
//            {$commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);}
//            else
//            {$commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);}
            $prixPromotion = $product->getPricePromotion() ? round($product->getPricePromotion(), 3) : round($product->getPrice(), 3);
            $commande['product'][$product->getId()] = array(
                'id' => $product->getId(),
                'image' => $product->getImage(),
                'name' => $product->getName(),
                'quantite' => $panier[$product->getId()],
                'slug' => $product->getSlug(),
                'price' => $prixPromotion,
                'vendeur' => $product->getStore()?$product->getStore()->getName():'SINDBAD',
                'id_vendeur' => $product->getStore()?$product->getStore()->getId():''
                //'prixTTC' => round($produit->getPrixunitaireht() / $produit->getTva()->getMultiplicate(),2)
                );
        }  
        
        $commande['livraison'] = array(
            'adresse' => $this->getUser()->getAdressLivraison(),
            'ville' => $this->getUser()->getCityLivraison(),
            'pays' => $this->getUser()->getCountry()
            );
        
        $commande['client'] = array(
            'nom_prenom' => $this->getUser()->getNom().' '.$this->getUser()->getPrenom(),
            'email' => $this->getUser()->getEmail(),
            'phone' => $this->getUser()->getPhone()
            );
        
        $commande['prix'] = round($total,3);
        //$commande['prixTTC'] = round($totalTTC,2);
        return $commande;
    }
    
    public function prepareCommande(Request $request)
    {
        $session = $request->getSession();
        $dm = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        if (!$session->has('commande'))
        {
            $commande = new Commandes();
        }
        else
        {
            $commande = $session->get('commande');
        }
        //dump($commande);die();
        $commande->setCreatedAt(new \DateTime('now'));
        $commande->setUpdatedAt(new \DateTime('now'));
        $commande->setUser($user);
        $commande->setStatus(0);
        $commande->setFacture($this->facture($request));
        
        $dm->persist($commande);
            
        
        $dm->flush();
        return new Response($commande->getId());
    }
    
    public function validationCommande($id, Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $commande = $dm->getRepository('App:Commandes')->find($id);
        
        if (!$commande || $commande->getStatus() == 1){
        return $this->redirect($this->generateUrl('index_page'));
        }
        $commande->setUpdatedAt(new \DateTime('now'));
        $commande->setStatus(1);
        $dm->persist($commande);
        $dm->flush();   
        
        $session = $request->getSession();
        //$session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
        $this->get('session')->getFlashBag()->add('success','Paiement éffectué avec succès');
        return $this->redirect($this->generateUrl('index_page'));
    }
    
    
    /*
     * list orders page
     */
    public function orders()
    {
        $dm = $this->getDoctrine()->getManager();
        $commandes = $dm->getRepository('App:Commandes')->findBy(array('user' => $this->getUser()));
        // foreach ($commandes as $c) {
        //     var_dump($c->getFacture());
        // }
        // die();
        return $this->render('commandes/front/list.html.twig', array(
            'commandes' => $commandes
        ));
        
    }
    
    /*
     * details order page
     */
    public function detailsOrder($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $commande = $dm->getRepository('App:Commandes')->find($id);
        return $this->render('commandes/front/show.html.twig', array(
            'commande' => $commande
        ));
    }
    
    
    /*
     * payement page
     */
    public function payement()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('commandes/front/payement.html.twig');
    }
    
    /*
     * livraison page
     */
    public function livraison()
    {
        $dm = $this->getDoctrine()->getManager();
        return $this->render('commandes/front/livraison.html.twig');
    }
}
