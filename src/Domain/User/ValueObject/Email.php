<?php

namespace Src\Domain\User\ValueObject;

final class Email{
    private string $value;

    public function __construct(string $email)
    {
        $this->value = $email;
    }

    public function getValue(): string {
        return $this->value;
    }
}