<?php
// src/Service/MessageGenerator.php
namespace App\Service;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class MessageGenerator
{
    private $logger;
    public  $name;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->name ="Service Example";
        echo "<pre>";
        print_r($this->logger);
        echo "<pre>";

    }
    // get the rand string form array
    public function getHappyMessage(): string
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }

    //retur simple name set in __construct
    public function name(): string
    {
        return $this->name;
    }
}
