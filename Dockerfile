FROM php:8.1-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip mysqli

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia composer.json y composer.lock
COPY composer.json composer.lock ./

# Instala Composer y dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --no-dev --prefer-dist

# Copia el código fuente
COPY ./src /var/www/html/

# Habilita el módulo rewrite de Apache
RUN a2enmod rewrite

# Expone el puerto
EXPOSE 80
