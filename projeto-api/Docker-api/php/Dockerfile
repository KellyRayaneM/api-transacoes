ARG PHP_VERSION
FROM php:$PHP_VERSION-fpm-alpine

# Copiando script que facilita instalação de extensões.
# Script: https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN apk update \
    upgrade;

# Usando script copiado acima para instalar as extensões
RUN install-php-extensions gd xdebug zip mysqli pdo pdo_mysql mcrypt calendar
RUN install-php-extensions bcmath
RUN install-php-extensions imap

RUN cd ~ \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN apk add --update --no-cache git bash;