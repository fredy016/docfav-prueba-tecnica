<?php

namespace Src\Infrastructure\Event;

use Src\Domain\User\Event\UserRegisteredEvent;
use Psr\Log\LoggerInterface;

final class SendWelcomeEmailHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(UserRegisteredEvent $event): void
    {
        $user = $event->getUser();
        $this->logger->info("Enviando email de bienvenida a " . $user->getEmail()->getValue());

        echo "Email enviado a " . $user->getEmail()->getValue() . " con mensaje: 'Bienvenido, " . $user->getName()->getValue() . ", tu usuario ha sido registrado exitosamente!'";
    }
}