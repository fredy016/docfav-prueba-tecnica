<?php

namespace Src\Domain\User\ValueObject;

use Src\Domain\User\Exception\InvalidEmailException;

final class Email{
    private string $value;

    public function __construct(string $email)
    {
        $this->validateEmail($email);
        $this->value = $email;
    }

    private function validateEmail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
    }

    public function getValue(): string {
        return $this->value;
    }
}