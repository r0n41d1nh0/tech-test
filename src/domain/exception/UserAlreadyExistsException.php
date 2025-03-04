<?php

namespace src\domain\exception;

class UserAlreadyExistsException extends \Exception
{
    public function __construct(string $email)
    {
        parent::__construct("User already exists with email: $email",409);
    }
}