<?php
// src/DemoService.php 
namespace  App\Service;
use Psr\Log\LoggerInterface;
use App\Service\PageService;
class RegisterService
{
  private $logger;
  private $mail;
  private $messageHash;
  private $pageService;
  private $default;
  private $id;
  

  public function __construct(LoggerInterface $logger, callable $sendMail,callable $generateMessageHash,PageService $pageService,$default="test",int $id=123)
  {
        $this->logger = $logger;
        $this->mail = $sendMail();
        $this->messageHash = $generateMessageHash();
        $this->pageService = $pageService;
        $this->default = $default;
        $this->id = $id;
       
  }

  public function helloWorld()
  {
    return "Hello World!\n";
  }
  
  public function log()
  {
    return $this->logger;
  }
  public function mailSend()
  {
    return $this->mail;
  }
  public function hashCall()
  {
    return $this->messageHash;
  }
  public function getRandomMessage(): string
  {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];
        echo $this->messageHash;
        $index = array_rand($messages);

        return $messages[$index];
  }
  public function pageService()
  {
    return $this->pageService;
  }
  public function pageRender()
  {
    
    return $this->pageService->pageRender();
  }
  public function default()
  {
    return $this->default.'---=>/Integer=>'.$this->id;
  }
  
}