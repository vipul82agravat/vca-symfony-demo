<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

//#[AsCommand(name: 'user-params-command')]
#[AsCommand(
    name: 'user-notify-command',
    description: 'Send User Notification Message.',
    hidden: false,
    aliases: ['user-notify']
)]
class UserNotificationCommand extends Command
{

    private $userDetails; 
    private $mailer;   

    public function __construct(ManagerRegistry $doctrine,MailerInterface $mailer)
    {
        $this->userDetails = $doctrine;
        $this->mailer = $mailer;

        parent::__construct();
    }


    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        // Use in-build functions to set name, description and help

        $this->setHelp('Run this command to execute your USer send mail for InActivte Status the execute function.');
           
    }

    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output): int
    {       

        
        //$user = $this->userDetails->getRepository(User::class)->findAll();
        $InActiveusers = $this->userDetails->getRepository(User::class)->findBy(['status' => 0]);
        
        if(count($InActiveusers) >=1) {

            foreach($InActiveusers as $key=>$user){

                $user_email=$user->getemail();
                $this->MailSend($user_email);
                echo "Mail is sent=> ".$user_email;
                echo "  --check you mail box";
                echo "\n";
            }

        }
        return Command::SUCCESS;
    }
    //send mail to InActiveUser
    public function MailSend($user_email){

        
        $email = (new Email())
	    ->from(new Address('vipulagravat@aum.bz', 'Mailtrap'))
		->to($user_email)
		->cc('vipulagravat@aum.bz')
        ->subject('User Account is InActive')
		->text('Hey!'.$user_email)
        ->html('<html>
                <body>
                <p><br>Hey</br>
                You User Account is InActive Now</p>
                <p>Please contact to Admin For Active Account</p>
                <a href="https://127.0.0.1:8000/">ActiveNow</a>
                        </body>
                    </html>');
        $this->mailer->send($email);
        return true;
    }
}