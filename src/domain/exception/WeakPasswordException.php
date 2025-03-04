<?php

namespace src\domain\exception;

class WeakPasswordException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Password does not meet security requirements.",422);
    }
}