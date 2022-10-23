<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityController extends BaseController {

    private $tokenManager;

    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }
    
    public function loginAdmin(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $csrfToken = $this->tokenManager
                ? $this->tokenManager->getToken('authenticate')->getValue()
                : null;

        return $this->render('user/loginAdmin.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $dm = $this->getDoctrine()->getManager();
        $error = $authenticationUtils->getLastAuthenticationError();
        $setting = $dm->getRepository('App:Settings')->find(1);
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $csrfToken = $this->tokenManager
                ? $this->tokenManager->getToken('authenticate')->getValue()
                : null;

        return $this->render('bundles/FOSUserBundle/Security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'setting' => $setting
        ]);
    }
    
    public function employeLogin(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $csrfToken = $this->tokenManager
                ? $this->tokenManager->getToken('authenticate')->getValue()
                : null;

        return $this->render('user/loginEmploye.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ]);
    }

}