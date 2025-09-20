# Gunakan PHP 8.3 FPM
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install zip intl pdo_mysql mbstring gd \
    && docker-php-ext-enable zip intl pdo_mysql mbstring gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install dependencies PHP
RUN composer install --optimize-autoloader --no-interaction --no-scripts

# Set permissions untuk Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose port default Railway
EXPOSE 8080

# Command untuk running Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080
