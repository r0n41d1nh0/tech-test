<?php

namespace src\domain\entity\valueObject;

class Password {
    private string $hash;

    public function __construct(string $password) {
        $this->validate($password);
        $this->hash = password_hash($password, PASSWORD_BCRYPT);
    }

    private function validate(string $password): string {
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^a-zA-Z\d]/', $password)) {
            throw new \InvalidArgumentException("Password does not meet security requirements.");
        }
        return $password;
    }

    public function getHash(): string {
        return $this->hash;
    }
}