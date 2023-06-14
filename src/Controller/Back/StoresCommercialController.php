<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Stores;
use App\Entity\User;
use App\Entity\Marchands;
use App\Entity\AdressesStore;
use App\Entity\AdressesUser;
use App\Entity\TelephonesUser;
use App\Entity\Banners;
use App\Entity\TelephonesStore;
use App\Entity\ProductsList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class StoresCommercialController extends Controller
{
    /*
     * Stores list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $stores = $dm->getRepository('App:Stores')->findAll();
        return $this->render('stores/back/emp/list.html.twig', array('stores' => $stores));
    }
    
    /*
     * Store details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        return $this->render('stores/back/emp/show.html.twig', array('store' => $store));
    }
    
    /*
     * New Store page
     */
    public function newAction()
    {
        return $this->render('stores/back/emp/new.html.twig');
    }
    
    /*
     * New Store traitement
     */
    public function newTraitementAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = new Stores();
        $user = new User();
        $marchand = new Marchands();
        if(count($user_by_username) > 0){
            $request->getSession()->getFlashBag()->add('danger', "Un marchand avec username ".$request->get('username')." exist déjà");
            return $this->redirectToRoute('commercialstores_back_new');
        }
        if(count($user_by_email) > 0){
            $request->getSession()->getFlashBag()->add('danger', "Un marchand avec email ".$request->get('email')." exist déjà");
            return $this->redirectToRoute('commercialstores_back_new');
        }
        /*start user document*/
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setDateNaissance($request->get('dateNaissance'));
        $user->setEnabled(1);
        $user->addRole('ROLE_MARCHAND');
        $options = [
                'cost' => 11,
                //'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $pass = $request->get('motdepasse');
            $password = password_hash($request->get('motdepasse'), PASSWORD_BCRYPT, $options);
            $user->setPassword($password);
        $dm->persist($user);
        /*end user document*/
        /*start marchand document*/
        $marchand->setMatriculeFiscale($request->get('matricule'));
        $marchand->setNrc($request->get('nrc'));
        
        $marchand->setUser($user);
        $dm->persist($marchand);
        $slug = preg_replace('/[^A-Za-z0-9. -]/', '', $request->get('storenom'));

        // Replace sequences of spaces with hyphen
        $slug = preg_replace('/  */', '-', $slug);

        // The above means "a space, followed by a space repeated zero or more times"
        // (should be equivalent to / +/)

        // You may also want to try this alternative:
        $slug = preg_replace('/\\s+/', '-', $slug);
        $s = $dm->getRepository('App:Stores')->findOneBy(array('slug'=>$slug));
        if($slug){$slug = $slug.'-'.rand(1,25412).'-'.rand(1,2541222).$request->get('nrc').$request->get('matricule');}
        $store->setSlug($slug);
        /*end marchand document*/
        /*start store document*/
        $store->setName($request->get('storenom'));
        $store->setLink($request->get('lien'));
        $store->setDescription($request->get('descriptionC'));
        $store->setCreatedAt(new \DateTime('now'));
        $store->setPrix($request->get('prix'));
        $store->getFinOffre(new \DateTime(''.$request->get('datedebut').''));
        $store->setFinOffre(new \DateTime(''.$request->get('datefin').''));
        if (isset($_FILES["couvertureC"]) && !empty($_FILES["couvertureC"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_shop_couvertures') . "/" . $fileName
            );
            $store->setImageCouverture($fileName);
        }
        if (isset($_FILES["iconeC"]) && !empty($_FILES["iconeC"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_shop_logo') . "/" . $fileName
            );
            $store->setLogo($fileName);
        }
        /*start adresse store document*/
        if(!empty($_POST['adresses'])){
            foreach ($_POST['adresses'] as $key => $item){
                $adresseStore = new AdressesStore();
                $adresseStore->setRue($_POST['adresses'][$key]);
                $adresseStore->setStore($store);
                $dm->persist($adresseStore);
            }
        }
        /*end adresse store document*/
        /*start phone store document*/
        if(!empty($_POST['phones'])){
            foreach ($_POST['phones'] as $key => $item){
                $phoneStore = new TelephonesStore();
                $phoneStore->setNumero($_POST['phones'][$key]);
                $phoneStore->setStore($store);
                $dm->persist($phoneStore);
            }
        }
        /*end phone store document*/
        $store->setMarchand($marchand);
        $dm->persist($store);
        /*end store document*/
        /*store banner*/
        $banner = new Banners();
        $banner->setStore($store);
        $dm->persist($banner);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le marchand ".$store->getName()." a été ajoutée");
        return $this->redirectToRoute('commercialstores_back_edit', array('id' => $store->getId()));
    }
    
    /*
     * Store edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        return $this->render('stores/back/emp/edit.html.twig', array('store' => $store));
    }
    
    /*
     * Edit Store traitement
     */
    public function editTraitementAction(Request $request, $id)
     {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        $marchand = $store->getMarchand();
        $user = $marchand->getUser();
        if(count($user_by_username) > 0){
            $request->getSession()->getFlashBag()->add('danger', "Le username ".$request->get('username')." exist déjà");
            return $this->redirectToRoute('commercialstores_back_edit', array('id' => $member->getId()));
        }
        if(count($user_by_email) > 0){
            $request->getSession()->getFlashBag()->add('danger', "L'email ".$request->get('email')." exist déjà");
            return $this->redirectToRoute('commercialstores_back_edit', array('id' => $member->getId()));
        }
        foreach ($store->getAdressesStore() as $adresse){
            $dm->remove($adresse);
        }
        foreach ($store->getTelephonesStore() as $telephone){
            $dm->remove($telephone);
        }
        
        /*start user document*/
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setDateNaissance($request->get('dateNaissance'));
        $dm->persist($user);
        /*end user document*/
        /*start marchand document*/
        $marchand->setMatriculeFiscale($request->get('matricule'));
        $marchand->setNrc($request->get('nrc'));
        $marchand->setUser($user);
        $dm->persist($marchand);
        /*end marchand document*/
        /*start store document*/
        $store->setName($request->get('storenom'));
        $store->setLink($request->get('lien'));
        $store->setDescription($request->get('descriptionC'));
        $store->setCreatedAt(new \DateTime('now'));
        $store->setPrix($request->get('prix'));
        $store->setDebutOffre(new \DateTime(''.$request->get('datedebut').''));
        $store->setFinOffre(new \DateTime(''.$request->get('datefin').''));
        if (isset($_FILES["couvertureC"]["name"]) && !empty($_FILES["couvertureC"]["name"])) {
            $file = $_FILES["couvertureC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["couvertureC"]["tmp_name"], $this->getParameter('images_shop_couvertures') . "/" . $fileName
            );
            $store->setImageCouverture($fileName);
        }
        if (isset($_FILES["iconeC"]["name"]) && !empty($_FILES["iconeC"]["name"])) {
            $file = $_FILES["iconeC"]["name"];
            $File_Ext = substr($file, strrpos($file, '.'));
            $fileName = md5(uniqid()) . $File_Ext;
            move_uploaded_file(
                    $_FILES["iconeC"]["tmp_name"], $this->getParameter('images_shop_logo') . "/" . $fileName
            );
            $store->setLogo($fileName);
        }
        /*start adresse store document*/
        if(!empty($_POST['adresses'])){
            foreach ($_POST['adresses'] as $key => $item){
                $adresseStore = new AdressesStore();
                $adresseStore->setRue($_POST['adresses'][$key]);
                $adresseStore->setStore($store);
                $dm->persist($adresseStore);
            }
        }
        /*end adresse store document*/
        /*start phone store document*/
        if(!empty($_POST['phones'])){
            foreach ($_POST['phones'] as $key => $item){
                $phoneStore = new TelephonesStore();
                $phoneStore->setNumero($_POST['phones'][$key]);
                $phoneStore->setStore($store);
                $dm->persist($phoneStore);
            }
        }
        /*end phone store document*/
        $store->setMarchand($marchand);
        $dm->persist($store);
        /*end store document*/
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le marchand ".$store->getName()." a été mis à jour");
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }
    
    /*
     * Delete store
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $store = $dm->getRepository('App:Stores')->find($id);
        $adressesStore = $dm->getRepository('App:AdressesStore')->findBy(array('store' => $store));
        $phonesStore = $dm->getRepository('App:TelephonesStore')->findBy(array('store' => $store));
        foreach ($adressesStore as $adresse){
            $dm->remove($adresse);
        }
        foreach ($phonesStore as $phone){
            $dm->remove($phone);
        }
        /*$marchand = $dm->getRepository('App:Marchands')->find($store->getMarchand());
        $user = $dm->getRepository('App:User')->find($marchand->getUser());
        $dm->remove($user);
        $dm->remove($marchand);*/
        $fileSystem->remove(array('symlink', $this->getParameter('images_shop_logo')."/".$store->getImageCouverture(), ''.$store->getImageCouverture().''));
        $fileSystem->remove(array('symlink', $this->getParameter('images_shop_logo')."/".$store->getLogo(), ''.$store->getLogo().''));
        $dm->remove($store);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le marchand ".$store->getName()." supprimée");
        return $this->redirectToRoute('dashboard_stores_back_index');
    }
}
