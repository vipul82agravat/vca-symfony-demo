<?php 
// src/Validator/ContainsAlphanumeric.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class isGmail extends Constraint
{
    public $message = 'The email  "{{ string }}" is not valid.';
 

    /**
     * @return string 
     */
    public function validatedBy()
    {
        return  \get_class($this).'Validator';
    }
}
