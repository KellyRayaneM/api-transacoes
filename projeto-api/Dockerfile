FROM php:8.0-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN set -eux; apt-get update; apt-get install -y git;
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN a2enmod rewrite

WORKDIR /var/www/html/api

COPY ./src/composer.json ./
COPY ./src/composer.lock ./

RUN composer install --no-scripts --no-autoloader && composer clear-cache

COPY ./src ./

RUN composer dump-autoload --optimize && composer run-script post-root-package-install

RUN chown -R www-data:www-data .
