<?php

namespace Src\Domain\User\Event;

use Src\Domain\User\Entity\User;

final class UserRegisteredEvent
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}