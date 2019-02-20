<?php
declare(strict_types=1);

namespace CodeShopping\Events;

use CodeShopping\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
