<?php
// src/Service/SomeService.php
namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Service\MessageGenerator;

class SessionService
{
        private $requestStack;

        public function __construct(RequestStack $requestStack)
        {
        $this->requestStack = $requestStack;

            // Accessing the session in the constructor is *NOT* recommended, since
            // it might not be accessible yet or lead to unwanted side-effects
            // $this->session = $requestStack->getSession();
        }
       public function getSessionData()
        {
            $sessionData = $this->requestStack->getSession();
            return $sessionData;
            // ...
        }
         public function setSessionData($key,$value)
        {
            $sessionData = $this->requestStack->getSession();
             $user_id=$sessionData->set($key,$value);
            return $sessionData;
            // ...
        }
}
