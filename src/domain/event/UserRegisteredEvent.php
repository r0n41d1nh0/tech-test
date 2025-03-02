<?php

namespace src\domain\event;

use src\domain\entity\valueObject\UserId;
use src\domain\entity\valueObject\Email;

class UserRegisteredEvent {
    private UserId $id;
    private Email $email;

    public function __construct(UserId $id, Email $email) {
        $this->id = $id;
        $this->email = $email;
    }

    public function getId(): UserId {
        return $this->id;
    }

    public function getEmail(): Email {
        return $this->email;
    }
}