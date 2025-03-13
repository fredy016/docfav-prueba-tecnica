<?php

namespace Src\Domain\User\Repository;

use Src\Domain\User\Entity\User;
use Src\Domain\User\ValueObject\ID;
use Src\Domain\User\ValueObject\Email;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(ID $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function delete(ID $id): void;
}