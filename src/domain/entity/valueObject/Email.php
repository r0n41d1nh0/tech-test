<?php

namespace src\domain\entity\valueObject;

use src\domain\exception\InvalidEmailException;

class Email {
    private string $value;

    public function __construct(string $email) {
        $this->value = $this->validate($email);
    }

    private function validate(string $email): string {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }
        return $email;
    }

    public function getValue(): string {
        return $this->value;
    }
}