<?php

namespace src\domain\entity;

use src\domain\entity\valueObject\Email;
use src\domain\entity\valueObject\Name;
use src\domain\entity\valueObject\Password;
use src\domain\entity\valueObject\UserId;
use DateTimeImmutable;

class User {
    private UserId $id;
    private Name $name;
    private Email $email;
    private Password $password;
    private DateTimeImmutable $createdAt;

    public function __construct(UserId $id, Name $name, Email $email, Password $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): UserId {
        return $this->id;
    }

    public function getName(): Name {
        return $this->name;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getPassword(): Password {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable {
        return $this->createdAt;
    }
}
