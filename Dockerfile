FROM php:8.3-fpm

# Install dependencies yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    && docker-php-ext-install zip intl pdo pdo_mysql \
    && docker-php-ext-enable intl zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-interaction --no-scripts

CMD ["php-fpm"]
