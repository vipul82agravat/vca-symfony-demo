<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UsertCreateEvent extends Event
{
    public const NAME = 'users.created';

    // ....
}