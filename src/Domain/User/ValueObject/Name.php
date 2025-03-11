<?php

namespace Src\Domain\User\ValueObject;

final class Name{
    private string $value;

    public function __construct(string $name)
    {
        $this->value = $name;
    }

    public function getValue(): string {
        return $this->value;
    }
}