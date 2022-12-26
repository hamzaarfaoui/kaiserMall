<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contacts;
use App\Entity\NewsLetter;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{
    /*
     * product details
     */
    public function productDetails($slug)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = $dm->getRepository('App:Products')->findOneByQB($slug);
        $infos = $product[0];
        $images = $dm->getRepository('App:MediasImages')->findByQB($infos['id']);
        return new JsonResponse(array('infos' => $infos, 'images' => $images));
    }

    /*
    * accueil
    */
    public function accueil()
    {
        $dm = $this->getDoctrine()->getManager();
        $sliders = $dm->getRepository('App:Sliders')->getAllSlidersMobile();
        $banners = $dm->getRepository('App:ProductsList')->getBanners();
        return new JsonResponse(array(
            'sliders' => $sliders,
            'banners' => $banners
        ));   
    }

    /*
     * products by category
     */
    public function productsByCategory($category)
    {
        $dm = $this->getDoctrine()->getManager();
        $products = $dm->getRepository('App:Products')->findByQB($category);
        return new JsonResponse(array('products' => $products));
    }
}
