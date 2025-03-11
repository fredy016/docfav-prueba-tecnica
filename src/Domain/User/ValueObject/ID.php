<?php

namespace Src\Domain\User\ValueObject;

use Ramsey\Uuid\Uuid;

final class ID{
    private string $value;

    public function __constructor() {
        $this->value = Uuid::uuid4()->toString();
    }

    public function getValue(){
        return $this->value;
    }
}