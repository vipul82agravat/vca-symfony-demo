<?php 
// src/Mail/MailNotifyMessage
namespace App\Mail;

class MailNotifyMessage
{
    public function __invoke(): string
    {
        echo $this->registerNotifiy();
        echo "<br>";
        echo $this->registerMailSend();
        return 'Send  Mail PLease check you mail box';
        // Compute and return a message hash
    }
    public function registerNotifiy(): string
    {
        return 'User Register Notification send Successfully';
        // Compute and return a message hash
    }
    public function registerMailSend(): string
    {
        return 'User Register Mail send Successfully';
        // Compute and return a message hash
    }
    
}