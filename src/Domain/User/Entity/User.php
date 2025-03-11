<?php

namespace Src\Domain\User\Entity;

use Src\Domain\User\ValueObject\ID;
use Src\Domain\User\ValueObject\Name;
use Src\Domain\User\ValueObject\Email;
use Src\Domain\User\ValueObject\Password;

final class User
{
    private ID $id;
    private Name $name;
    private Email $email;
    private Password $password;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        ID $id,
        Name $name,
        Email $email,
        Password $password,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ID
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}