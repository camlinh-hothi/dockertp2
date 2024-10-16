# etape3/Dockerfile.php
FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY ./src /var/www/html
