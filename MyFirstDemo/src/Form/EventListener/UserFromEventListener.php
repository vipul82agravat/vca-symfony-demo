<?php
// src/Form/EventListener/AddEmailFieldListener.php
namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserFromEventListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::POST_SET_DATA => 'onPostSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
            FormEvents::POST_SUBMIT   => 'onPostSubmit'
        ];
    }

    public function onPreSetData(FormEvent $event): void
    {
        $user = $event->getData();
        $form = $event->getForm();
        // dd($user,$form);
        // checks whether the user from the initial data has chosen to
        // display their email or not.
        echo  "<br>";
        echo "PreSetData Subscibe event is call";
        echo  "<br>";
    }
    public function onPostSetData(FormEvent $event): void
    {
        $user = $event->getData();
        $form = $event->getForm();
        // dd($user,$form);
        // checks whether the user from the initial data has chosen to
        // display their email or not.
        echo  "<br>";
        echo "Post SetData Subscibe event is call";
        echo  "<br>";
    }

    public function onPreSubmit(FormEvent $event): void
    {
        
        $user = $event->getData();
        $form = $event->getForm();
        
        if (!$user) {
            return;
        }
        echo  "<br>";
        echo "Pre Submit Subscibe event is call";
        echo  "<br>";
        // checks whether the user has chosen to display their email or not.
        // If the data was submitted previously, the additional value that
        // // is included in the request variables needs to be removed.
        // if (isset($user['showEmail']) && $user['showEmail']) {
        //     $form->add('email', EmailType::class);
        // } else {
        //     unset($user['email']);
        //     $event->setData($user);
        // }
    }
    public function onPostSubmit(FormEvent $event): void
    {
        $user = $event->getData();
        $form = $event->getForm();

        if (!$user) {
            return;
        }

        echo  "<br>";
        echo "Post Submit Subscibe event is call";
        echo  "<br>";
        // checks whether the user has chosen to display their email or not.
        // If the data was submitted previously, the additional value that
        // is included in the request variables needs to be removed.
    } 
}