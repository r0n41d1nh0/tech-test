<?php

require_once __DIR__ . '/../vendor/autoload.php';

use src\infrastructure\controller\RegisterUserController;
use src\infrastructure\repository\DoctrineUserRepository;
use src\infrastructure\event\SimpleEventDispatcher;

$entityManager = require __DIR__ . '/../src/config/doctrine.php';
$userRepository = new DoctrineUserRepository($entityManager);
$eventDispatcher = new SimpleEventDispatcher();

$controller = new RegisterUserController($userRepository, $eventDispatcher);
$controller->register();
