<?php 
// src/Service/MessageGenerator.php
namespace App\Service;
use Psr\Log\LoggerInterface;

class MessageGenerator
{

    private $logger;
    private $messageHash;

    public function __construct(LoggerInterface $logger, callable $generateMessageHash)
    {
        $this->logger = $logger;
        $this->messageHash = $generateMessageHash();

    }
    public function getHappyMessage(): string
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
}