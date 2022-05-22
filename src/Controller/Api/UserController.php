<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contacts;
use App\Entity\NewsLetter;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserController extends Controller
{
    /*
     * login
     */
    public function login($username, $password)
    {
        
        $this->redirectToRoute('fos_user_security_check');
        return new JsonResponse(
            array(
                'Title' => 'Welcome '. $user->getUsername(),
                'Infos' => $user
            )
            //Response::HTTP_OK,
            //array('Content-type' => 'application/json')
        );
    }
}
