<?php

namespace Tests\Application\UseCase;

use PHPUnit\Framework\TestCase;
use Mockery;
use Src\Application\UseCase\RegisterUserUseCase;
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

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepository;
    private $eventDispatcher;
    private $registerUserUseCase;

    protected function setUp(): void
    {
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->eventDispatcher = Mockery::mock(EventDispatcher::class);
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testExecuteSuccessfullyRegistersUser()
    {
        $name = 'Fredy example';
        $email = 'fredy@example.com';
        $password = 'password123';
        $request = new RegisterUserRequest($name, $email, $password);

        $this->userRepository
            ->shouldReceive('findByEmail')
            ->with(Mockery::type(Email::class))
            ->andReturnNull();

        $this->userRepository
            ->shouldReceive('save')
            ->with(Mockery::type(User::class))
            ->once();

        $this->eventDispatcher
            ->shouldReceive('dispatch')
            ->with(Mockery::type(UserRegisteredEvent::class))
            ->once();

        $user = $this->registerUserUseCase->execute($request);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->getName()->value());
        $this->assertEquals('john.doe@example.com', $user->getEmail()->value());
    }

    public function testExecuteThrowsExceptionWhenEmailAlreadyRegistered()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('El email ya está registrado.');

        $name = 'Fredy example';
        $email = 'fredy@example.com';
        $password = 'passwo##rd123';
        $request = new RegisterUserRequest($name, $email, $password);
        
        $this->userRepository
            ->shouldReceive('findByEmail')
            ->with(Mockery::type(Email::class))
            ->andReturn(new User(
                new ID(),
                new Name('Otro Usuario'),
                new Email('fredy@example.com'),
                new Password('dasdasda#$!dadasdsad222')
            ));

        $this->registerUserUseCase->execute($request);
    }
}