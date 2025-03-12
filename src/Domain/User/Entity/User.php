<?php

namespace Src\Domain\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

use Src\Domain\User\ValueObject\ID;
use Src\Domain\User\ValueObject\Name;
use Src\Domain\User\ValueObject\Email;
use Src\Domain\User\ValueObject\Password;


#[ORM\Entity]
#[ORM\Table(name: "user")]
final class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ID $id;

    #[ORM\Column(type: "string", length: 100)]
    private Name $name;

    #[ORM\Column(type: "string", length:100, unique: true)]
    private Email $email;

    #[ORM\Column(type: "string")]
    private Password $password;

    #[ORM\Column(type: "datetime")]
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
        $this->createdAt = new DateTimeImmutable();
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