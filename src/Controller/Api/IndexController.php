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
    public function productDetails($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $product = $dm->getRepository('App:Products')->findOneByQById($id);
        $infos = $product[0];
        $images = $dm->getRepository('App:MediasImages')->findByQBMobile($infos['id']);
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
        $list_products = array();
        foreach ($banners as $key => $banner) {
            if($banner['show_list_products'] == 1 && $key <= 3){
                $products = $dm->getRepository('App:ListHasProducts')->byBannerMobile($banner['slug']);
                $list_products[$banner['title']] = $products; 
            }
        }
        return new JsonResponse(array(
            'sliders' => $sliders,
            'banners' => $banners,
            'lists_products' => $list_products
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
