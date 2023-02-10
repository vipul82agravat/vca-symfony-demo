<?php
// src/Service/MessageGenerator.php
namespace App\Service;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class InjectMessageGenerator
{
    private $logger;
    public  $name;
    private $messageHash;
    public function __construct(LoggerInterface $logger,callable $generateMessageHash)
    {
        $this->logger = $logger;
        $this->name ="Service Example";
        $this->messageHash = $generateMessageHash();
        echo "<pre>";
        print_r($this->messageHash);
        echo "<pre>";

    }
    // get the rand string form array
    public function getInjectMessage()
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);
        $arr=['messageHash'=>$this->messageHash,'msg'=>$messages[$index]];
        return $arr;
    }

    //retur simple name set in __construct
    public function name(): string
    {
        return $this->name;
    }
}
