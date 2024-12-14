FROM php:8.1-apache

# Instala extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip mysqli

# Copia composer.json y composer.lock
COPY composer.json /var/www/html/composer.json
COPY composer.lock /var/www/html/composer.lock

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el binario de Composer desde su imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias de Composer
RUN composer install --no-scripts --no-dev --prefer-dist

# Copia el código fuente del proyecto
COPY ./src /var/www/html/

# Habilita el módulo rewrite de Apache
RUN a2enmod rewrite
