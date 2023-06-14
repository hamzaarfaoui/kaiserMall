<?php

namespace App\Controller\Front\Marchand;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Favoris;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\AdressesStore;
use App\Entity\TelephonesStore;

class MarchandController extends Controller
{
    /*
     * store list
     */
    public function listStore()
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $dm = $this->getDoctrine()->getManager();
        $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()));
        if(!$marchand){
          $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()->getOwner()));  
        }
        
        $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
        return $this->render('marchand/storesList.html.twig', array('store' => $store));
    }
    
    /*
     * store infos page
     */
    public function infosStore(Request $request)
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }   
        $dm = $this->getDoctrine()->getManager();
        $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()));
        if(!$marchand){
          $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()->getOwner()));  
        }
        
        $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
        $form = $this->createForm('App\Form\StoreType', $store);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $dm->persist($store);
            $dm->flush();
            $this->addFlash('success','Votre infos sont enregistrés');
            
            return $this->redirectToRoute('marchand_stores_details', array('id' => $store->getId()));
        }
        return $this->render('marchand/infosStore.html.twig', array(
            'store' => $store,
            'form' => $form->createView(),
        ));
    }
    
    /*
     * store visuels page
     */
    public function visuels(Request $request)
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $dm = $this->getDoctrine()->getManager();
        $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()));
        if(!$marchand){
          $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()->getOwner()));  
        }
        
        $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
        
        return $this->render('marchand/visuels.html.twig', array(
            'store' => $store
        ));
    }
    
    /*
     * store visuels traitement
     */
    public function visuelsTraitement(Request $request)
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $dm = $this->getDoctrine()->getManager();
        $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()));
        if(!$marchand){
          $marchand = $dm->getRepository('App:Marchands')->findOneBy(array('user' => $this->getUser()->getOwner()));  
        }
        
        $store = $dm->getRepository('App:Stores')->findOneBy(array('marchand' => $marchand));
        if (isset($_FILES["couvertureC"]) && !empty($_FILES["couvertureC"]['name'])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_shop_couvertures') . "/" . $fileName
            );
            $store->setImageCouverture($fileName);
        }
        if (isset($_FILES["iconeC"]) && !empty($_FILES["iconeC"]['name'])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_shop_logo') . "/" . $fileName
            );
            $store->setLogo($fileName);
        }
        $dm->persist($store);
        $dm->flush();
        $this->addFlash('success','Vos visuels sont enregistrés');
        return $this->redirectToRoute('marchand_stores_visuels', array('id' => $store->getId()));
    }
    
    /*
     * store add adress
     */
    public function addAdressStore(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($request->get('store'));
        $adresseStore = new AdressesStore();
        $adresseStore->setRue($request->get('adress'));
        $adresseStore->setStore($store);
        $store->addAdresseStore($adresseStore);
        $dm->persist($store);
        $dm->persist($adresseStore);
        $dm->flush();
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => 'Adresse '.$adresseStore->getRue().' ajouté',
            'adress' => $this->renderView('marchand/partials/single_adress.html.twig', array('adress' => $adresseStore))
            ));
        
    }
    
    /*
     * store edit adress
     */
    public function editAdressStore(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $adresseStore = $dm->getRepository('App:AdressesStore')->find($id);
        $adresseStore->setRue($request->get('adress'));
        $dm->persist($adresseStore);
        $dm->flush();
        return new JsonResponse(array('status' => 'OK', 'message' => 'Adresse '.$adresseStore->getRue().' enregistrée'));
        
    }
    
    /*
     * store delete adress
     */
    public function deleteAdressStore(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $adresseStore = $dm->getRepository('App:AdressesStore')->find($id);
        $dm->remove($adresseStore);
        $dm->flush();
        return new JsonResponse(array('status' => 'OK', 'message' => 'Adresse '.$adresseStore->getRue().' supprimé'));
        
    }
    
    /*
     * store add phone
     */
    public function addPhoneStore(Request $request)
    {
         $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($request->get('store'));
        $phoneStore = new TelephonesStore();
        $phoneStore->setNumero($request->get('phone'));
        $phoneStore->setStore($store);
        $store->addTelephoneStore($phoneStore);
        $dm->persist($store);
        $dm->persist($phoneStore);
        $dm->flush();
        return new JsonResponse(array(
            'status' => 'OK',
            'message' => 'Phone '.$phoneStore->getNumero().' ajouté',
            'phone' => $this->renderView('marchand/partials/single_phone.html.twig', array('phone' => $phoneStore))
            ));
    }
    
    /*
     * store edit phone
     */
    public function editPhoneStore(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $phoneStore = $dm->getRepository('App:TelephonesStore')->find($id);
        $phoneStore->setNumero($request->get('phone'));
        $dm->persist($phoneStore);
        $dm->flush();
        return new JsonResponse(array('status' => 'OK', 'message' => 'phone '.$phoneStore->getNumero().' enregistrée'));
    }
    
    /*
     * store delete phone
     */
    public function deletePhoneStore(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $phoneStore = $dm->getRepository('App:TelephonesStore')->find($id);
        $dm->remove($phoneStore);
        $dm->flush();
        return new JsonResponse(array('status' => 'OK', 'message' => 'phone '.$phoneStore->getNumero().' supprimé'));
        
    }
}
