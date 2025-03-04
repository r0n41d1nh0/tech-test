<?php

namespace src\domain\exception;

class InvalidEmailException extends \Exception
{
    public function __construct(string $email)
    {
        parent::__construct("Invalid email: $email",422);
    }
}