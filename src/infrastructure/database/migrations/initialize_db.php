<?php

use Doctrine\DBAL\DriverManager;

require_once __DIR__ . '/../../../../vendor/autoload.php';

$connectionParams = [
    'dbname'   => 'test_db',
    'user'     => 'user',
    'password' => 'password',
    'host'     => '192.168.100.102',  // Si usas IP fija: '192.168.100.20'
    'driver'   => 'pdo_mysql',
];

try {
    $conn = DriverManager::getConnection($connectionParams);

    // Consulta para crear la tabla si no existe
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS users (
            id VARCHAR(36) PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            createdAt DATETIME NOT NULL
        );
    ";

    $conn->executeStatement($createTableSQL);
    echo "Tabla 'users' verificada o creada exitosamente.\n";

} catch (\Exception $e) {
    echo "Error al crear la tabla: " . $e->getMessage() . "\n";
}