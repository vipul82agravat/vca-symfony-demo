<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Psr\Log\LoggerInterface;

class SendEmailService 
{

    private $mailer;   
    private $logger;  
    public function __construct(MailerInterface $mailer,LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;

    }

    public function storeLog() : void {
        
        $this->logger->info('I just got the logger');
        $this->logger->error('An error occurred');
        $this->logger->debug('User {userId} has logged in', [
            'userId' => '1',
        ]);
    
        $this->logger->critical('I left the oven on!', [
            // include extra "context" info in your logs
            'cause' => 'in_hurry',
        ]);
        
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