<?php

namespace Src\Domain\User\ValueObject;

use Src\Domain\User\Exception\WeakPasswordException;

final class Password{
    private const  MIN_LENGTH = 8;
    private string $value;

    public function __construct(string $password)
    {
        $this->validatePassword($password);
        $this->value = password_hash($password, PASSWORD_BCRYPT);
    }

    private function validatePassword(string $password): void
    {
        if (strlen(trim($password)) < self::MIN_LENGTH) {
            throw new WeakPasswordException();
        }
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->value);
    }

    public function getValue(): string {
        return $this->value;
    }
}