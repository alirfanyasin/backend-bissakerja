# FROM php:8.3-fpm

# # System deps
# RUN apt-get update && apt-get install -y \
#     git unzip libpq-dev libzip-dev libonig-dev zip \
#  && docker-php-ext-install pdo_mysql mbstring zip bcmath opcache \
#  && rm -rf /var/lib/apt/lists/*

# # Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www/html
# COPY . .

# # Install vendors (no dev) and optimize
# RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
#  && mkdir -p storage bootstrap/cache \
#  && chown -R www-data:www-data storage bootstrap/cache

# # Opcache recommended ini
# RUN { \
#       echo 'opcache.enable=1'; \
#       echo 'opcache.enable_cli=0'; \
#       echo 'opcache.validate_timestamps=0'; \
#       echo 'opcache.memory_consumption=256'; \
#       echo 'opcache.interned_strings_buffer=16'; \
#       echo 'opcache.max_accelerated_files=20000'; \
#     } > /usr/local/etc/php/conf.d/opcache.ini

# EXPOSE 9000
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


# Gunakan PHP 8.3 + ekstensi Laravel
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /var/www/html

# Copy semua file ke container
COPY . .

# Install dependensi Laravel
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Laravel permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

# Jalankan Laravel pakai PHP built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
