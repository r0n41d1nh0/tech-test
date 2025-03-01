<?php

namespace src\tests\integration;

use PHPUnit\Framework\TestCase;
use src\domain\entity\User;
use src\domain\entity\valueObject\Email;
use src\domain\entity\valueObject\Name;
use src\domain\entity\valueObject\Password;
use src\domain\entity\valueObject\UserId;
use src\infraestructure\repository\DoctrineUserRepository;

class DoctrineUserRepositoryTest extends TestCase {

    private DoctrineUserRepository $repository;
    private User $user;

    protected function setUp(): void {

        $entityManager = require 'src/config/doctrine.php';
        $this->repository = new DoctrineUserRepository($entityManager);

        $this->user = new User(
            new UserId(),
            new Name('Ronald Gomez'),
            new Email('rgomez@dominio.pe'),
            new Password('miContrasenha123*')
        );
    }

    public function testSaveUser() {
        $this->repository->save($this->user);
        $testUser = $this->repository->findById($this->user->getId());

        $this->assertNotNull($testUser);
        $this->assertEquals($this->user->getId()->getValue(), $testUser->getId()->getValue());
        $this->assertEquals($this->user->getEmail()->getValue(), $testUser->getEmail()->getValue());
    }

    public function testDeleteUser() {
        $this->repository->save($this->user);
        $this->repository->delete($this->user);
        $testUser = $this->repository->findById($this->user->getId());

        $this->assertNull($testUser);
    }

    protected function tearDown(): void {
        $this->repository->delete($this->user);
    }
    
}