<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration([dirname(__DIR__) . "/infrastructure/doctrine"], true);
$connection = DriverManager::getConnection([
    'dbname' => 'test_db',
    'user' => 'user',
    'password' => 'password',
    'host' => '192.168.100.102',
    'driver' => 'pdo_mysql',
]);

$entityManager =new EntityManager($connection, $config);

return $entityManager;