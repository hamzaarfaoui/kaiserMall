<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\AdressesUser;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Category controller.
 *
 * @Route("adresses")
 */
class AdressesUserController extends Controller
{
    /**
     * Lists all AdressesUser entities.
     *
     * @Route("/", name="adresses_user_index")
     * @Method("GET")
     */
    public function index()
    {
        $dm = $this->getDoctrine()->getManager();
        $adresses = $dm->getRepository('App:AdressesUser')->findBy(array('user' => $this->getUser()));
        return $this->render('user/adresses/index.html.twig', array(
            'adresses' => $adresses,
        ));
    }
    
    
    /**
     * Lists all AdressesUser entities.
     *
     * @Route("/new", name="adresses_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAdresseUser(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $adresseUser = new AdressesUser();
        $form = $this->createForm('App\Form\AdresseUserType', $adresseUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adresseUser->setPays('Tunisie');
            $adresseUser->setUser($this->getUser());
            $dm->persist($adresseUser);
            $dm->flush();
            return new JsonResponse(array(
                'adresse' => $adresseUser,
                'html' => $this->renderView('user/adresses/singleAdresse.html.twig', ['adresse' => $adresseUser])
            ));
        }
        return $this->render('user/adresses/form.html.twig', array(
            'adresse_form' => $form->createView(),
            'action' => $this->container->get('router')->generate('adresses_user_new'),
            'type' => 'Nouvelle'
        ));
    }
    
    /**
     * Lists all AdressesUser entities.
     *
     * @Route("/edit/{id}", name="adresses_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAdresseUser(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $adresseUser = $dm->getRepository('App:AdressesUser')->find($id);
        $form = $this->createForm('App\Form\AdresseUserType', $adresseUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm->persist($adresseUser);
            $dm->flush();
            return $this->redirectToRoute('fos_user_profile_edit');
        }
        return $this->render('user/adresses/form.html.twig', array(
            'adresse' => $adresseUser,
            'adresse_form' => $form->createView(),
            'type' => 'Modification',
            'action' => $this->container->get('router')->generate('adresses_user_edit', ['id' => $adresseUser->getId()])
        ));
    }
    
    /**
     * Lists all AdressesUser entities.
     *
     * @Route("/delete/{id}", name="adresses_user_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAdresseUser(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $adresseUser = $dm->getRepository('App:AdressesUser')->find($id);
        $dm->remove($adresseUser);
        $dm->flush();
        return new JsonResponse(array(
            'id' => $adresseUser->getId(),
            'message' => 'Adresse supprimé'.$adresseUser->getRue()
        ));
    }
    
    
}
