<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmployesController extends Controller
{
    /*
     * employes list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $employes = $dm->getRepository('App:User')->findAll();
        $employes_list = array();
        foreach ($employes as $employe){
            if(in_array('ROLE_COMMERCIAL', $employe->getRoles()) || in_array('ROLE_GESTIONNEAIRE_STOCK', $employe->getRoles())){
                $employes_list[] = $employe;
            }
        }
        return $this->render('employes/list.html.twig', array('employes' => $employes_list));
    }
    
    /*
     * employe details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $employe = $dm->getRepository('App:User')->find($id);
        $role = '';
        if(in_array('ROLE_COMMERCIAL', $employe->getRoles())){
            $role = 'Commercial';
        }elseif (in_array('ROLE_GESTIONNEAIRE_STOCK', $employe->getRoles())) {
            $role = 'Gestionnaire de stock';
        }
        return $this->render('employes/show.html.twig', array('employe' => $employe, 'role' => $role));
    }
    
    /*
     * employes list
     */
    public function newEmploye()
    {
        return $this->render('employes/new.html.twig');
    }
    
    /*
     * New employe
     */
    public function newEmployeAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $employe = new User();
        $employe->setNom($request->get('nom'));
        $employe->setPrenom($request->get('prenom'));
        $employe->setEmail($request->get('email'));
        $employe->setUsername($request->get('username'));
        $employe->setPhone($request->get('phone'));
        $employe->setRoles([$request->get('role')]);
        $employe->setEnabled(1);
        $options = [
                'cost' => 11,
                //'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
        $pass = $request->get('password');
        $password = password_hash($pass, PASSWORD_BCRYPT, $options);
        $employe->setPassword($password);
        $employe->setCreatedAt(new \DateTime('now'));
        $employe->setUpdatedAt(new \DateTime('now'));
        $dm->persist($employe);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "l'employé ".$employe->getNom()." ".$employe->getPrenom(). " a été ajoutée");
        return $this->redirectToRoute('dashboard_employes_edit', array('id' => $employe->getId()));
    }
    
    /*
     * employes list
     */
    public function editEmploye($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $employe = $dm->getRepository('App:User')->find($id);
        $role = $employe->getRoles()[0];
        return $this->render('employes/edit.html.twig', array('employe' => $employe, 'role' => $role));
    }
    
    /*
     * employe edit
     */
    public function editEmployeAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $employe = $dm->getRepository('App:User')->find($id);
        $employe->setNom($request->get('nom'));
        $employe->setPrenom($request->get('prenom'));
        $employe->setEmail($request->get('email'));
        $employe->setUsername($request->get('username'));
        $employe->setPhone($request->get('phone'));
        $employe->setRoles([$request->get('role')]);
        $employe->setCreatedAt(new \DateTime('now'));
        $employe->setUpdatedAt(new \DateTime('now'));
        $dm->persist($employe);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "l'employé ".$employe->getNom()." ".$employe->getPrenom(). " a été mis à jour");
        return $this->redirectToRoute('dashboard_employes_edit', array('id' => $employe->getId()));
    }
    
    /*
     * employe status
     */
    public function employeStatus(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $employe = $dm->getRepository('App:User')->find($id);
        if($employe->isEnabled() == 1){
            $employe->setEnabled(0);
            $message = "Le compte de l'employe".$employe->getUsername()." est désactivé";
        }else{
            $employe->setEnabled(1);
            $message = "Le compte de l'employe".$employe->getUsername()." est activé";
        }
        $dm->persist($employe);
        $dm->flush();
        return new JsonResponse(array('message' => $message));
    }
    
    
    
    /*
     * Delete employe
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $employe = $dm->getRepository('App:User')->find($id);
        $dm->remove($employe);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "l'employé ".$employe->getNom()." ".$employe->getPrenom(). " a été supprimé");
        return $this->redirectToRoute('dashboard_employes_index');
    }
}
