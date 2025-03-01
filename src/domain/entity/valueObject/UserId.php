<?php

namespace src\domain\entity\valueObject;
use Ramsey\Uuid\Uuid;

class UserId {
    private string $value;

    public function __construct(?string $id=null) {
        $this->value = $id ? $this->validate($id) : $this->generateUuid();
    }

    private function validate(string $id): string {
        if (!preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[1-5][a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/i', $id)) {
            throw new \InvalidArgumentException("Invalid UUID format: $id");
        }
        return $id;
    }

    private function generateUuid(): string {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function getValue(): string {
        return $this->value;
    }
}