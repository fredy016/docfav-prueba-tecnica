include .env
export $(shell sed 's/=.*//' .env)

# Nombre de los contenedores
APP_CONTAINER=php_app
DB_CONTAINER=db_app

# Levantar los contenedores con la nueva configuración
up:
	docker-compose --env-file .env up --build -d

# Detener los contenedores
down:
	docker-compose down

# Ver logs en tiempo real de la aplicación
logs:
	docker-compose logs -f $(APP_CONTAINER)

# Acceder al contenedor PHP
php-bash:
	docker-compose exec $(APP_CONTAINER) bash

# Acceder a la base de datos MySQL
db:
	docker-compose exec $(DB_CONTAINER) mysql -u$(MYSQL_USER) -p$(MYSQL_PASSWORD) $(MYSQL_DATABASE)

# Ejecutar Composer install dentro del contenedor
composer-install:
	docker-compose exec $(APP_CONTAINER) composer install

# Ejecutar migraciones de Doctrine
migrate:
	docker-compose exec $(APP_CONTAINER) php vendor/bin/doctrine-migrations migrate  --configuration=config/migrations.php --db-configuration=config/migrations-db.php
 
# Ver estado de las migraciones
migration-status:
	docker-compose exec $(APP_CONTAINER) php vendor/bin/doctrine-migrations migrations:status --configuration=config/migrations.php --db-configuration=config/migrations-db.php

# Crear una nueva migración
migration-create:
	docker-compose exec $(APP_CONTAINER) php vendor/bin/doctrine-migrations diff --configuration=config/migrations.php --db-configuration=config/migrations-db.php

migration-g:
	docker-compose exec $(APP_CONTAINER) php vendor/bin/doctrine-migrations migrations:generate --configuration=config/migrations.php --db-configuration=config/migrations-db.php

# Ejecutar pruebas (si usas PHPUnit)
test:
	docker-compose exec $(APP_CONTAINER) vendor/bin/phpunit

# Reiniciar el entorno eliminando volúmenes y datos
reset:
	docker-compose down -v
	docker-compose --env-file .env up --build -d