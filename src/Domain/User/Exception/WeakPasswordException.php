<?php

namespace Src\Domain\User\Exception;

use DomainException;

final class WeakPasswordException extends DomainException
{
    protected $message = 'La contraseña es demasiado débil.';
}