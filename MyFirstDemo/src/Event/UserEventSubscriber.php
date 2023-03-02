<?php

namespace App\Event;

use App\Event\UsertCreateEvent;
use App\Event\UserUpdateEvent;
use App\Event\UserDeleteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Event\LifecycleEventArgs;


class UserEventSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
      
    }
    // Returns an array indexed by event name and value by method name to call
    public static function getSubscribedEvents()
    {
        return [
            UsertCreateEvent::NAME => 'onProductCreation',
            //hook multiple functions with the events with priority for sequence of function calls
            UserUpdateEvent::NAME => [
                ['onProductUpdation', 1],
            ],
            UserDeleteEvent::NAME => 'onProductDeletion',
            KernelEvents::RESPONSE => 'onKernelResponse',   
        ];
    }

    public function onProductCreation(UsertCreateEvent $event)
    {
        echo "Creatre action call";
        echo "<br>";
        echo '<a href="../../user_index">Back</a>';
        // write code to execute on product creation event
    }
    public function onProductUpdation(UserUpdateEvent $event)
    {
        echo "Update action call";
        echo '<a href="../../user_index">Back</a>';
        echo "<br>";
        // write code to execute on product creation event
    }

    public function onProductDeletion(UserDeleteEvent $event)
    {
        echo "Delete action call";
        echo '<a href="../../user_index">Back</a>';
        echo "<br>";
        // write code to execute on product creation event
    }

        public function onKernelResponse(ResponseEvent  $event)
    {
        // write code to execute on in-built Kernel Response event
    }
    
}
