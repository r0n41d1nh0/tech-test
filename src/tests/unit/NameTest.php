<?php

namespace src\tests\unit;

use PHPUnit\Framework\TestCase;
use src\domain\entity\valueObject\Name;

class NameTest extends TestCase {
    public function testValidNameIsAccepted(): void {
        $name = new Name("Ronald Gómez");
        $this->assertEquals("Ronald Gómez", $name->getValue());
    }

    public function testEmptyNameIsRejected(): void {
        $this->expectException(\InvalidArgumentException::class);
        new Name("");
    }

    public function testNameWithNumbersIsRejected(): void {
        $this->expectException(\InvalidArgumentException::class);
        new Name("RonaldGomez123");
    }

    public function testNameWithSpecialCharactersIsRejected(): void {
        $this->expectException(\InvalidArgumentException::class);
        new Name("Ronald Gomez@");
    }

    public function testNameWithLessThan2CharactersIsRejected(): void {
        $this->expectException(\InvalidArgumentException::class);
        new Name("A");
    }

}