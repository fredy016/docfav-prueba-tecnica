<?php

namespace Src\Application\UseCase;

use Src\Application\DTO\RegisterUserRequest;
use Src\Domain\User\Entity\User;
use Src\Domain\User\Repository\UserRepositoryInterface;
use Src\Domain\User\Event\UserRegisteredEvent;
use Src\Infrastructure\Event\EventDispatcher;
use Src\Domain\User\ValueObject\ID;
use Src\Domain\User\ValueObject\Name;
use Src\Domain\User\ValueObject\Email;
use Src\Domain\User\ValueObject\Password;

use DomainException;

final class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcher $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcher $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): User
    {
        if ($this->userRepository->findByEmail(new Email($request->email))) {
            throw new DomainException("El email ya está registrado.");
        }

        $user = new User(
            new ID(),
            new Name($request->name),
            new Email($request->email),
            new Password($request->password)
        );

        $this->userRepository->save($user);

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user));

        return $user;
    }
}