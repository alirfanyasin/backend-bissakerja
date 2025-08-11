FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000 9000

# Default jalankan php-fpm
CMD ["php-fpm"]
