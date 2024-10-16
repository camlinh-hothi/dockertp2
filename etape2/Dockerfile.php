# etape2/Dockerfile.php
FROM php:7.4-fpm

# Installer les extensions PDO et MySQLi pour interagir avec MariaDB/MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copier les fichiers PHP dans le répertoire /app du container
COPY ./src /app
