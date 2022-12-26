<?php

namespace App\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Document\Clients;

/**
 * Listener responsible for adding the default user role at registration
 */
class RegistrationListener implements EventSubscriberInterface
{
    private $router;
    
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm',
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onChangePassword',
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onProfileEdit',
            
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $rolesArr = array('ROLE_CLIENT');

        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
        $user->setRoles($rolesArr);
        
    }
    
    public function onRegistrationConfirm(FormEvent $event)
    {
        $this->router->redirect('fos_user_profile_edit');
    }
    
    public function onChangePassword(FormEvent $event)
    {
        $url = $this->router->generate('fos_user_profile_edit');

        $event->setResponse(new RedirectResponse($url));
    }
    
    public function onProfileEdit(FormEvent $event)
    {
        $url = $this->router->generate('fos_user_profile_edit');

        $event->setResponse(new RedirectResponse($url));
    }
}
