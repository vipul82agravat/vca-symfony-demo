<?php
// src/Service/SomeService.php
namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\MessageGenerator;

class FactorySiteManager
{

        public function getParams()
        {
            // ...

            // generate a URL with no route arguments

            $response=['auto_adminEmail'=>'1','email'=>1];
            return $response;

        }
}
