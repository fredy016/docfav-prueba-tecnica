<?php

namespace Tests\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use Mockery;
use Src\Infrastructure\Repository\DoctrineUserRepository;
use Src\Domain\User\Entity\User;
use Src\Domain\User\ValueObject\ID;
use Src\Domain\User\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepositoryTest extends TestCase
{
    private $entityManager;
    private $doctrineUserRepository;

    protected function setUp(): void
    {
        $this->entityManager = Mockery::mock(EntityManagerInterface::class);
        $this->doctrineUserRepository = new DoctrineUserRepository($this->entityManager);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSave()
    {
        $user = Mockery::mock(User::class);

        $this->entityManager
            ->shouldReceive('persist')
            ->with($user)
            ->once();

        $this->entityManager
            ->shouldReceive('flush')
            ->once();

        $this->doctrineUserRepository->save($user);

        $this->assertTrue(true); // Solo para verificar que el método se ejecutó sin errores
    }

    public function testFindById()
    {
        $userId = new ID();
        $user = Mockery::mock(User::class);

        $this->entityManager
            ->shouldReceive('find')
            ->with(User::class, $userId->getValue())
            ->andReturn($user);

        $result = $this->doctrineUserRepository->findById($userId);

        $this->assertSame($user, $result);
    }

    public function testFindByEmail()
    {
        $userEmail = new Email('fredy@example.com');
        $user = Mockery::mock(User::class);

        $this->entityManager
            ->shouldReceive('find')
            ->with(User::class, $userEmail->getValue())
            ->andReturn($user);

        $result = $this->doctrineUserRepository->findByEmail($userEmail);

        $this->assertSame($user, $result);
    }

    public function testDelete()
    {
        $userId = new ID();
        $user = Mockery::mock(User::class);

        $this->entityManager
            ->shouldReceive('find')
            ->with(User::class, $userId->getValue())
            ->andReturn($user);

        $this->entityManager
            ->shouldReceive('remove')
            ->with($user)
            ->once();

        $this->entityManager
            ->shouldReceive('flush')
            ->once();

        $this->doctrineUserRepository->delete($userId);

        $this->assertTrue(true);
    }

    public function testDeleteWhenUserNotFound()
    {
        $userId = new ID();

        $this->entityManager
            ->shouldReceive('find')
            ->with(User::class, $userId->getValue())
            ->andReturnNull();

        $this->entityManager
            ->shouldNotReceive('remove');

        $this->entityManager
            ->shouldNotReceive('flush');

        $this->doctrineUserRepository->delete($userId);

        $this->assertTrue(true); 
    }
}