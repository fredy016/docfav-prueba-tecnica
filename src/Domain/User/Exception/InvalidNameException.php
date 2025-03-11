<?php

namespace Src\Domain\User\Exception;

use DomainException;

final class InvalidNameException extends DomainException
{
    protected $message = 'El nombre no cumple con los requisitos minimos';
}