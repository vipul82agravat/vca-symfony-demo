<?php 
// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserDBListener
{
    public function postPersist(LifecycleEventArgs $args): void
    {
        
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof User) {
            return;
        }

       
        // ... do something with the Product entity
    }
}
