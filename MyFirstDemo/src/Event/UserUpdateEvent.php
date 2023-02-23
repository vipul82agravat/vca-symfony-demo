<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserUpdateEvent extends Event
{
    public const NAME = 'user.updated';

    // ....
}