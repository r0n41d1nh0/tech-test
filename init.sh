#!/bin/bash

echo "Inicializando entorno de desarrollo..."

docker compose up --build -d

echo "Esperando que se carguen todos los servicios"
sleep 10


echo "Ejecutando migraciones..."
docker exec php_app php src/infrastructure/database/migrations/initialize_db.php

echo "Entorno listo. Puedes registrar usuarios en http://localhost:8000/register.php"
