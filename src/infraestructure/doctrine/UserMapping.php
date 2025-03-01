<?php

namespace src\infraestructure\doctrine;

use Doctrine\ORM\Mapping as ORM;
use src\domain\entity\User;
use src\domain\entity\valueObject\Email;
use src\domain\entity\valueObject\Name;
use src\domain\entity\valueObject\Password;
use src\domain\entity\valueObject\UserId;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: "users")]

class UserMapping {

    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "string")]
    private string $email;

    #[ORM\Column(type: "string")]
    private string $password;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    public function __construct(User $user) {
        $this->id = $user->getId()->getValue();
        $this->name = $user->getName()->getValue();
        $this->email = $user->getEmail()->getValue();
        $this->password = $user->getPassword()->getHash();
        $this->createdAt = $user->getCreatedAt();
    }

    public function toDomain(): User {
        return new User(
            new UserId($this->id),
            new Name($this->name),
            new Email($this->email),
            new Password($this->password),
            $this->createdAt
        );
    }
}