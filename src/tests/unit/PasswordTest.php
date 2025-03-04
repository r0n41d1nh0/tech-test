<?php

namespace src\tests\unit;

use PHPUnit\Framework\TestCase;
use src\domain\entity\valueObject\Password;
use src\domain\exception\WeakPasswordException;

class PasswordTest extends TestCase
{
    public function testValidPasswordIsAccepted(): void {
        $password = new Password("Str0ng@Pass123");
        $this->assertNotEmpty($password->getHash());
    }

    public function testPasswordWithoutUppercaseIsRejected(): void {
        $this->expectException(WeakPasswordException::class);
        new Password("str0ng@pass123");
    }

    public function testPasswordIsEncrypted(): void
    {
        $password = new Password('SecurePass@2025');
        $this->assertNotEquals('SecurePass@2025', $password->getHash());
    }

    public function testPasswordWithoutNumbersIsRejected(): void {
        $this->expectException(WeakPasswordException::class);
        new Password("Strong@Password");
    }

    public function testPasswordWithoutSpecialCharactersIsRejected(): void {
        $this->expectException(WeakPasswordException::class);
        new Password("StrongPass123");
    }

    public function testPasswordWithLessThan8CharactersIsRejected(): void {
        $this->expectException(WeakPasswordException::class);
        new Password("A@1b");
    }

}