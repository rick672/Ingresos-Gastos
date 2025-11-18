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

# Instalar extensiones PHP básicas
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

# Configurar Apache para Laravel
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto
COPY . /var/www/html

# Establecer permisos
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Resetear completamente la base de datos y recrear
RUN php artisan db:wipe --force
RUN php artisan migrate --force
RUN php artisan db:seed --force