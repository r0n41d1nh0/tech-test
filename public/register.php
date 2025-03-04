<?php

require_once __DIR__ . '/../vendor/autoload.php';

use src\infrastructure\controller\RegisterUserController;
use src\infrastructure\repository\DoctrineUserRepository;
use src\infrastructure\event\SimpleEventDispatcher;
use src\application\useCase\RegisterUserUseCase;

$entityManager = require __DIR__ . '/../src/config/doctrine.php';
$userRepository = new DoctrineUserRepository($entityManager);
$eventDispatcher = new SimpleEventDispatcher();
$useCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

$controller = new RegisterUserController($useCase);
$controller->register();
