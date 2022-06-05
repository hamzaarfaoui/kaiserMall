<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use App\Entity\User;
use App\Entity\Marchands;
use App\Entity\AdressesStore;
use App\Entity\AdressesUser;
use App\Entity\TelephonesUser;
use App\Entity\TelephonesStore;
use App\Entity\MediasImages;
use App\Entity\Promotions;
use App\Entity\Keywords;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\DirectoryType;

class ListProductsBackController extends Controller
{   
    /*
     * Product details
     */
    public function details($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $list_products = $dm->getRepository('App:ProductsList')->find($id);
        $list_has_products = $dm->getRepository('App:listHasProducts')->getProductListe($id);
        return $this->render('Products/back/listProducts.html.twig', array(
            'list_products' => $list_products,
            'list_has_products' => $list_has_products
        ));
    }
}
