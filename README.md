# 🐘 Proyecto PHP con Docker y MySQL

Este proyecto es una API desarrollada en PHP utilizando Docker y MySQL.

## 🚀 Instalación

1. **Clonar el repositorio**  
   ```sh
   git clone https://github.com/r0n41d1nh0/tech-test
   cd tech-test

2. **Configurar variables de entorno**  
   ```sh
   cp .env.example .env

3. **Iniciar el entorno con Docker**  
   ```sh
   ./init.sh

4. **Puedes probar con curl**  
   ```sh
    curl -X POST http://localhost:8000/register.php \
     -H "Content-Type: application/json" \
     -d '{"name": "Ronald Gómez", "email": "rgomez@example.pe", "password": "StrongPass@123"}'

5. **Puedes ejecutar los test**  
   ```sh
     docker compose run --rm phpunit