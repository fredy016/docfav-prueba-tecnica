# Proyecto PHP con Doctrine y Docker

Este proyecto utiliza PHP 7.4 con Composer y Doctrine ORM para la gestión de base de datos. Se implementa una arquitectura hexagonal y el entorno se despliega con Docker y Docker Compose.

## Estructura del Proyecto

```
/project-root
│── config/
│   ├── doctrine.php
│   ├── migrations.php
│   ├── mappings/
│── docker/
│   ├── Dockerfile
│   ├── my.cnf
│── migrations/
│── public/
│   ├── index.php
│── src/
│   ├── Application/
│   ├── Domain/
│   ├── Infrastructure/
│── vendor/
│── .env
│── composer.json
│── docker-compose.yml
│── Makefile
│── README.md
```

## Requisitos

- Docker
- Docker Compose
- Make (opcional, facilita los comandos de despliegue)

## Instalación y despliegue

### 1. Clonar el repositorio

```sh
git clone https://github.com/fredy016/docfav-prueba-tecnica
cd docfav-prueba-tecnica
```

### 2. Configurar variables de entorno

Copiar el archivo de ejemplo y modificarlo según la configuración deseada:

```sh
cp .env.example .env
```

### 3. Construir y levantar los servicios

```sh
make build
make up
```

### 4. Instalar dependencias PHP con Composer

```sh
make composer-install
```

### 5. Generar migraciones y aplicar cambios en la base de datos

```sh
make migration-create
make migration-migrate
```

### 6. Verificar que la aplicación está funcionando

Acceder a `http://localhost:8080` en el navegador o usar `curl`:

```sh
curl http://localhost:8080
```

## Comandos útiles

- Detener los servicios:
  ```sh
  make down
  ```
- Ver logs de contenedores:
  ```sh
  make logs
  ```
- Ejecutar una shell dentro del contenedor PHP:
  ```sh
  make shell
  ```

## Notas

Si hay problemas con las migraciones, revisar que la base de datos esté correctamente creada y conectada.

---
