<?php

namespace Src\Domain\User\Repository;

use Src\Domain\User\Entity\User;
use Src\Domain\User\ValueObject\ID;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(ID $id): ?User;
    public function delete(ID $id): void;
}