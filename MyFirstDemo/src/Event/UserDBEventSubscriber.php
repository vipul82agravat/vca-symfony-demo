<?php

namespace App\Event;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;



class UserDBEventSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $mailer;  

    public function __construct(LoggerInterface $logger,MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        
    }
    // public function __construct()
    // { 
    // }
    
    // Returns an array indexed by event name and value by method name to call
    public  function getSubscribedEvents()
    {
        return [
            Events::prePersist, 
            Events::postPersist,
            Events::preRemove,
            Events::postRemove,
            Events::preUpdate,
            Events::postUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
       
        $this->logActivity('pre_persist', $args);
    }
    
    public function postPersist(LifecycleEventArgs $args): void
    {   
        
        $this->logActivity('post_persist', $args);

    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('pre_remove', $args);
    }
    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('post_remove', $args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        
        $this->logActivity('pre_update', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
      
        $this->logActivity('post_update', $args);
    }
    
    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
            
        $entity = $args->getObject();
        
        if($action=="post_persist"){
           
            $user_email=$entity->getemail();
            
            $subject="Account Registration";
            $html='<html>
            <body>
            <p><br>Hey</br>
            Your  Account  Registration is Complated </p>
            <p>You can Access your Active Account</p>
            <a href="https://127.0.0.1:8000/">Access Account</a>
                    </body>
                </html>';

             //$this->MailSend($user_email, $subject, $html);
             $this->logger->info('User mail send!'.$action);
            // add some code to check the entity type as early as possible
           
        }
        $this->logger->info('I just got the logger'.$action);
        if (!$entity instanceof User) {
            return;
        }
        // if this subscriber only applies to certain entity types,
        
        // ... get the entity information and log it somehow
    }
    //send mail to InActiveUser
    public function MailSend($user_email,$subject,$html){
            
        $email = (new Email())
            ->from(new Address('vipulagravat@aum.bz', 'Mailtrap'))
            ->to($user_email)
            ->cc('vipulagravat@aum.bz')
            ->subject($subject)
            ->text('Hey!'.$user_email)
            ->html($html);
        $this->mailer->send($email);
    }    
    
}
