<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\NullLogger;

use Src\Infrastructure\Event\EventDispatcher;
use Src\Controller\RegisterUserController;
use Src\Application\UseCase\RegisterUserUseCase;
use Src\Domain\User\Event\UserRegisteredEvent;
use Src\Domain\User\Repository\UserRepositoryInterface;
use Src\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Src\Infrastructure\Event\SendWelcomeEmailHandler;
use Src\Infrastructure\DI\Container;

$entityManager = require __DIR__ . '/../config/doctrine.php';

$container = new Container();

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener(UserRegisteredEvent::class, new SendWelcomeEmailHandler(new NullLogger()));

$container->set(EventDispatcherInterface::class, fn() => $eventDispatcher);
$container->set(UserRepositoryInterface::class, fn() => new DoctrineUserRepository($entityManager));
$container->set(RegisterUserUseCase::class, fn($c) => new RegisterUserUseCase($c->get(UserRepositoryInterface::class),$c->get(EventDispatcherInterface::class)));
$container->set(RegisterUserController::class, fn($c) => new RegisterUserController($c->get(RegisterUserUseCase::class)));

$request = Request::createFromGlobals();
$path = $request->getPathInfo();

$controller = $container->get(RegisterUserController::class);

if ($path === '/user/register' && $request->getMethod() === 'POST') {
    $response = $controller->register($request);
} else {
    $response = new JsonResponse(['error' => 'Ruta no encontrada'], 404);
}
$response->send();