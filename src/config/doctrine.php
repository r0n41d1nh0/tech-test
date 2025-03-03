<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration([dirname(__DIR__) . "/infrastructure/doctrine"], true);
$connection = DriverManager::getConnection([
    'dbname' => 'testdb',
    'user' => 'root',
    'password' => '12345678',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
]);

$entityManager =new EntityManager($connection, $config);

return $entityManager;