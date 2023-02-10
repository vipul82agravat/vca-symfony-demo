<?php
// src/Service/MessageGenerator.php
namespace App\Service;

//only access in development mode in project

#[When(env: 'dev')]
class RandomNumberGenerator
{
    public function getNumber(): string
    {
        // generate rand number in init 1 to 10
        $number = rand(1,10);
        return $number;
    }
}
