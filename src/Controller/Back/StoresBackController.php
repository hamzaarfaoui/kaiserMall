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

class StoresBackController extends Controller
{
    /*
     * Stores list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $stores = $dm->getRepository('App:Stores')->findAll();
        return $this->render('stores/back/list.html.twig', array('stores' => $stores));
    }
    
    /*
     * Store details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        $banner = $dm->getRepository('App:Banners')->findOneBy(array('store' => $id));
        if(!$banner){
            $banner = new Banners();
            $banner->setStore($store);
            $dm->persist($banner);
            $dm->flush();
        }
        return $this->render('stores/back/show.html.twig', array('store' => $store, 'banner' => $banner));
    }
    
    /*
     * New Store page
     */
    public function newAction()
    {
        return $this->render('stores/back/new.html.twig');
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
        return $this->redirectToRoute('dashboard_stores_back_edit', array('id' => $store->getId()));
    }
    
    /*
     * Store edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($id);
        return $this->render('stores/back/edit.html.twig', array('store' => $store));
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
        return $this->redirectToRoute('dashboard_stores_back_edit', array('id' => $store->getId()));
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

    /*
     * Stores list group products
     */
    public function listGroupProductsAction($store)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($store);
        $lists = $dm->getRepository('App:ProductsList')->findBy(array('store' => $store));
        return $this->render('stores/back/productsList.html.twig', array('store' => $store, 'lists' => $lists));
    }

    /*
     * Stores new group products
     */
    public function newGroupProductsAction($store)
    {
        $dm = $this->getDoctrine()->getManager();
        $store = $dm->getRepository('App:Stores')->find($store);
        $products = $dm->getRepository('App:Products')->findBy(array('store' => $store));
        return $this->render('stores/back/newProductsList.html.twig', array('store' => $store, 'products' => $products));
    }

    /*
     * Stores new group products traitement
     */
    public function newGroupProductsTraitementAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $id_store = $request->get('store');
        $store = $dm->getRepository('App:Stores')->find($id_store);
        $group = new ProductsList();
        $lists = $dm->getRepository('App:ProductsList')->findBy(array('store' => $store));
        $postion = count($lists)+1;
        $group->setName($_POST["nom"]);
        $group->setPosition($postion);
        $group->setStore($store);
        $dm->persist($group);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "Le group : ".$group->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_stores_products_liste', array('store' => $id_store));
    }
    /*
     * Stores change position of group products
     */
    public function changePositionGroupProductsAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        for($i=0; $i<count($request->get('group_id_array')); $i++)
        {
            $group = $dm->getRepository('App:ProductsList')->find($request->get('group_id_array')[$i]);
            $group->setPosition($i);
            $dm->persist($group);
        }
        $dm->flush();
        return $this->redirectToRoute('dashboard_stores_products_liste', array('store' => $id_store));
    }
    /*
     * Store group products details
     */
    public function groupProductsDetailsAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $group = $dm->getRepository('App:ProductsList')->find($id);
        $list_ids = array();
        foreach ($group->getProducts() as $product) {
            $list_ids[] = $product->getId();
        }
        $store = $dm->getRepository('App:Stores')->find($group->getStore()->getId());
        return $this->render('stores/back/productsListDetails.html.twig', array('group' => $group, 'store'=>$store, 'list_ids' => $list_ids));
    }
    /*
     * Stores change position of group products
     */
    public function addProductInGroupAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $checked = $request->get('ischecked');
        $product = $dm->getRepository('App:Products')->find($request->get('id_product'));
        $group = $dm->getRepository('App:ProductsList')->find($request->get('group'));
        if($checked == 1){
            $group->addProduct($product);
        }else{
            $group->removeProduct($product);
        }
        $dm->persist($group);
        $dm->flush();
        return $this->redirectToRoute('dashboard_stores_add_product_in_group', array('id' => $request->get('id_product')));
    }
}
