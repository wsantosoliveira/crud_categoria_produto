<?php

namespace CodeShopping\Listeners;

use CodeShopping\Events\UserCreatedEvent;

class SendEmailToDefinePassowrdListener
{
    public function __construct()
    {
    }

    public function handle(UserCreatedEvent $event)
    {
    }
}
