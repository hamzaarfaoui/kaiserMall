<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingsController extends Controller
{
    /*
     * settings list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $settings = $dm->getRepository('App:Settings')->findAll();
        return $this->render('settings.html.twig', array(
            'settings' => $settings,
        ));
    }
    
    /*
     * setting update
     */
    public function editAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $id = $request->get('setting');
        $value = $request->get('value');
        $setting = $dm->getRepository('App:Settings')->find($id);
        $setting->setValue($value);
        $dm->persist($setting);
        $dm->flush();
        return new JsonResponse(array('status' => true, 'message' => $setting->getName().' a été mise à jour'));
    }
}
