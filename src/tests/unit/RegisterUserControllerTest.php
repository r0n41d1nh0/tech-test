<?php

namespace src\tests\unit;

use PHPUnit\Framework\TestCase;
use src\infrastructure\controller\RegisterUserController;
use src\application\useCase\RegisterUserUseCase;
use src\application\dto\RegisterUserRequest;
use src\domain\repository\UserRepositoryInterface;
use src\domain\event\EventDispatcherInterface;
use src\domain\exception\InvalidEmailException;
use src\domain\exception\WeakPasswordException;
use src\domain\exception\UserAlreadyExistsException;

class RegisterUserControllerTest extends TestCase
{
    private $userRepository;
    private $eventDispatcher;
    private $useCase;
    private RegisterUserController $controller;

    protected function setUp(): void {
        
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->useCase = $this->createMock(RegisterUserUseCase::class);

        $this->controller = new RegisterUserController($this->useCase );
    }

    private function captureOutput(callable $callable): string {
        ob_start();
        $callable();
        return ob_get_clean();
    }

    public function testUserIsRegisteredSuccessfully(): void {
        
        $this->mockPhpInput(json_encode([
            'name' => 'Ronald Gómez',
            'email' => 'rgomez@example.pe',
            'password' => 'StrongPass@123'
        ]));

        $output = $this->captureOutput(function() {
            $this->controller->register();
        });

        $this->assertStringContainsString('User registered successfully', $output);
    }

    public function testErrorIfMissingFields(): void {
        $this->mockPhpInput(json_encode(['name' => 'Ronald Gómez']));

        $output = $this->captureOutput(function() {
            $this->controller->register();
        });

        $this->assertStringContainsString('Missing required fields', $output);
    }

    public function testErrorIfEmailAlreadyExists(): void {
        $this->mockPhpInput(json_encode([
            'name' => 'Ronald Gómez',
            'email' => 'rgomez@example.pe',
            'password' => 'StrongPass@123'
        ]));

        $this->useCase->expects($this->once())
        ->method('execute')
        ->willThrowException(new UserAlreadyExistsException('rgomez@example.pe'));

        $output = $this->captureOutput(function() {
            $this->controller->register();
        });
        
        $decodedOutput = json_decode($output, true);
        $this->assertEquals('User already exists with email: rgomez@example.pe', $decodedOutput['error']);
    }

    public function testErrorIfEmailIsInvalid(): void {
        $this->mockPhpInput(json_encode([
            'name' => 'Ronald Gómez',
            'email' => 'invalid-email',
            'password' => 'StrongPass@123'
        ]));

        $this->useCase->expects($this->once())
            ->method('execute')
            ->willThrowException(new InvalidEmailException('invalid-email'));

        $output = $this->captureOutput(function() {
            $this->controller->register();
        });

        $decodedOutput = json_decode($output, true);
        $this->assertEquals('Invalid email: invalid-email', $decodedOutput['error']);
    }

    public function testErrorIfPasswordIsWeak(): void {
        $this->mockPhpInput(json_encode([
            'name' => 'Ronald Gómez',
            'email' => 'rgomez@example.pe',
            'password' => 'weakpass'
        ]));

        $this->useCase->expects($this->once())
            ->method('execute')
            ->willThrowException(new WeakPasswordException());

        $output = $this->captureOutput(function() {
            $this->controller->register();
        });

        $decodedOutput = json_decode($output, true);
        $this->assertEquals('Password does not meet security requirements.', $decodedOutput['error']);
    }

    private function mockPhpInput(string $input): void {
        global $TEST_REQUEST_BODY;
        $TEST_REQUEST_BODY = $input;
    }

}