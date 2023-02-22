<?php
 //src/Service/SiteUpdateManager.php
 // ...
 namespace App\Service;
 use App\Service;

 class SiteUpdateManager
 {
     // ...
    private $adminEmail;

    public function __construct(MessageGenerator $messageGenerator, string $adminEmail)
     {
         // ...
       $this->adminEmail = $adminEmail;
     }

     public function notifyOfParams(): string
     {
         // ...
            return $this->adminEmail;
         // ...
     }
 }