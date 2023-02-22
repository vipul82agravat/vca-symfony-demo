<?php 
// src/Hash/MessageHashGenerator.php
namespace App\Hash;

class MessageHashGenerator
{
    public function __invoke(): string
    {
        return 'hii';
        // Compute and return a message hash
    }
}