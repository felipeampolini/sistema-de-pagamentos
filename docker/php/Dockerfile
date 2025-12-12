FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    zip unzip git curl nano libzip-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo_mysql zip intl

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório do projeto
WORKDIR /var/www
