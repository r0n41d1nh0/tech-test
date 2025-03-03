<?php

namespace src\domain\entity\valueObject;

class Name {
    private string $value;

    public function __construct(string $name) {
        $this->value = $this->validate($name);
    }

    private function validate(string $name): string {
        if (strlen($name) < 2 || !preg_match('/^[\p{L}\s]+$/u', $name)) {
            throw new \InvalidArgumentException("Invalid name format.");
        }
        return $name;
    }

    public function getValue(): string {
        return $this->value;
    }
}