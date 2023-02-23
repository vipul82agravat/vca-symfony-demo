<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserDeleteEvent extends Event
{
    public const NAME = 'user.deleted';

    // ....
}