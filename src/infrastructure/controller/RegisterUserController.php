<?php

namespace src\infrastructure\controller;

use src\application\useCase\RegisterUserUseCase;
use src\application\dto\RegisterUserRequest;
use src\domain\repository\UserRepositoryInterface;
use src\domain\event\EventDispatcherInterface;

use src\domain\exception\UserAlreadyExistsException;
use src\domain\exception\WeakPasswordException;
use src\domain\exception\InvalidEmailException;

class RegisterUserController
{
    private RegisterUserUseCase $useCase;

    public function __construct(RegisterUserUseCase $useCase) {
        $this->useCase = $useCase;
    }

    public function register(): void {
        global $TEST_REQUEST_BODY;
        $input = json_decode($TEST_REQUEST_BODY ?? file_get_contents("php://input"), true);

        if (!isset($input['name']) || !isset($input['email']) || !isset($input['password'])) {
            $this->sendResponse(['error' => 'Missing required fields'],400);
            return;
        }

        try {
            $request = new RegisterUserRequest(trim($input['name']), trim($input['email']), trim($input['password']));
            $this->useCase->execute($request);
            $this->sendResponse(['message' => 'User registered successfully'],201);
        } catch (InvalidEmailException | WeakPasswordException $e) {
            $this->sendResponse(['error' => $e->getMessage()], 422);
        } catch (UserAlreadyExistsException $e) {
            $this->sendResponse(['error' => $e->getMessage()], 409);  
        } catch (\Exception $e) {
            $this->sendResponse(['error' => 'An unexpected error occurred'], 500);
        }
    }

    private function sendResponse(array $response, int $statusCode): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}