<?php

namespace Src\Domain\User\ValueObject;

final class Password{
    private string $value;

    public function __construct(string $password)
    {
        $this->value = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getValue(): string {
        return $this->value;
    }
}