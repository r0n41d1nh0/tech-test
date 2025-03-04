<?php

namespace src\tests\unit;

use PHPUnit\Framework\TestCase;
use src\application\useCase\RegisterUserUseCase;
use src\application\dto\RegisterUserRequest;
use src\domain\entity\User;
use src\domain\entity\valueObject\Email;
use src\domain\entity\valueObject\Password;
use src\domain\entity\valueObject\Name;
use src\domain\entity\valueObject\UserId;
use src\domain\repository\UserRepositoryInterface;
use src\domain\event\UserRegisteredEvent;
use src\domain\event\EventDispatcherInterface;
use src\domain\exception\UserAlreadyExistsException;

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepository;
    private $eventDispatcher;
    private RegisterUserUseCase $useCase;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->useCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    public function testUserIsRegisteredSuccessfully(): void {
        $request = new RegisterUserRequest('Ronald Gomez', 'rgomez@example.pe','$trongPass@123');
        $this->userRepository->method('findByEmail')->willReturn(null);
        $this->userRepository->expects($this->once())->method('save');
        $this->eventDispatcher->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UserRegisteredEvent::class));
        $this->useCase->execute($request);
    }

    public function testExceptionIsThrownIfEmailAlreadyExists(): void {
        $request = new RegisterUserRequest("Juan Pérez", "juan@example.com", "SecurePass@2024");
        $this->expectException(UserAlreadyExistsException::class);
        $this->expectExceptionMessage('User already exists with email: '.$request->getEmail());

        $existingUser = new User(
            new UserId(),
            new Name("Juan Pérez"),
            new Email("juan@example.com"),
            new Password("SecurePass@2024")
        );
        $this->userRepository->method('findByEmail')->willReturn($existingUser);
        $this->useCase->execute($request);

    }
}