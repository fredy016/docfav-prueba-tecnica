FROM php:7.4-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git mariadb-client && \
    docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./public /var/www/html/public
COPY ./src /var/www/html/src
COPY ./config /var/www/html/config
COPY ./migrations /var/www/html/migrations
COPY composer.json composer.lock /var/www/html/

ARG DATABASE_URL
ENV DATABASE_URL=${DATABASE_URL}

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]