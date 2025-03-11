<?php

namespace Src\Domain\User\Exception;

use DomainException;

final class InvalidEmailException extends DomainException
{
    protected $message = 'Formato invalido para Email';
}