<?php

namespace Src\Application\DTO;

use Src\Domain\User\Entity\User;

final class UserResponseDTO
{
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;

    public function __construct(User $user)
    {
        $this->id = (string) $user->getId()->getValue();
        $this->name = $user->getName()->getValue();
        $this->email = $user->getEmail()->getValue();
        $this->createdAt = $user->getCreatedAt()->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}