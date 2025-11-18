FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    libonig-dev \
    libxml2-dev

# Instalar extensiones PHP básicas (sin intl por ahora)
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    mysqli \
    zip \
    xml \
    mbstring

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto
COPY . /var/www/html

# Establecer permisos
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# Instalar dependencias de Composer (ignorando extensiones faltantes)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs