<?php

namespace src\domain\entity\valueObject;

class Name {
    private string $value;

    public function __construct(string $name) {
        $this->value = $this->validate($name);
    }

    private function validate(string $name): string {
        if (strlen($name) < 2) {
            throw new \InvalidArgumentException("Name must be at least 2 characters long");
        }
        return $name;
    }

    public function getValue(): string {
        return $this->value;
    }
}