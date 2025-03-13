<?php

namespace Src\Infrastructure\Persistence\Doctrine;

use Src\Domain\User\Entity\User;
use Src\Domain\User\Repository\UserRepositoryInterface;
use Src\Domain\User\ValueObject\ID;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(ID $id): ?User
    {
        return $this->entityManager->find(User::class, $id->getValue());
    }

    public function delete(ID $id): void
    {
        $user = $this->findById($id);
        if ($user !== null) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}