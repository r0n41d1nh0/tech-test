<?php

namespace src\application\useCase;

use src\application\dto\RegisterUserRequest;
use src\domain\entity\User;
use src\domain\entity\valueObject\Email;
use src\domain\entity\valueObject\Name;
use src\domain\entity\valueObject\Password;
use src\domain\entity\valueObject\UserId;
use src\domain\repository\UserRepositoryInterface;
use src\domain\event\UserRegisteredEvent;
use src\domain\event\EventDispatcherInterface;
use src\domain\exception\UserAlreadyExistsException;

class RegisterUserUseCase {
    private UserRepositoryInterface $repository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UserRepositoryInterface $repository, EventDispatcherInterface $eventDispatcher) {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): void {
        $email = new Email($request->getEmail());
        if ($this->repository->findByEmail($email) !== null) {
            throw new UserAlreadyExistsException($email->getValue());
        }

        $user = new User(
            new UserId(),
            new Name($request->getName()),
            new Email($request->getEmail()),
            new Password($request->getPassword())
        );

        $this->repository->save($user);

        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user->getId(), $user->getEmail()));
    }
}