<?php

namespace Src\Domain\User\ValueObject;

use Src\Domain\User\Exception\InvalidNameException;

final class Name{
    private string $value;
    private const  MIN_LENGTH = 3;
    private const NAME_REGEX = '/^[a-zA-Z\s]+$/';
    

    public function __construct(string $name)
    {
        $this->validateName($name);
        $this->value = $name;
    }

    public function validateName($name){
        if (strlen($name) < self::MIN_LENGTH) {
            throw new InvalidNameException();
        }

        if (!preg_match(self::NAME_REGEX, $name)) {
            throw new \InvalidArgumentException("El nombre solo puede contener letras y espacios.");
        }
    }

    public function getValue(): string {
        return $this->value;
    }
}