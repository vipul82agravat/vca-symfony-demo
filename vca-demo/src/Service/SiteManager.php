<?php
// src/Service/SomeService.php
namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\MessageGenerator;

class SiteManager
{
        private $adminEmail;
        private $messageGenerator;
        public function __construct(private UrlGeneratorInterface $router,MessageGenerator $messageGenerator,string $adminEmail)
        {
             $this->adminEmail = $adminEmail;
             $this->messageGenerator = $messageGenerator;
        }

        public function getParams()
        {
            // ...

            // generate a URL with no route arguments
            $signUpPage = $this->router->generate('blog_list');
            $Message=$this->messageGenerator->getHappyMessage();

            $full_signUpPage = $this->router->generate('blog_list', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $response=['email'=>$this->adminEmail,'url'=>$signUpPage,'msg'=>$Message,'full_url'=>$full_signUpPage];
            return $response;

        }
}
