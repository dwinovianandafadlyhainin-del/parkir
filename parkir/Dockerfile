# ===== Dockerfile - Aplikasi Parkir [hainin] =====
FROM php:8.2-fpm

LABEL maintainer="hainin - SIJA XI"

# Install dependency sistem & ekstensi PHP
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/parkir-hainin
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Copy konfigurasi Nginx custom
COPY docker/nginx-hainin.conf /etc/nginx/sites-available/default

# Permission storage & cache
RUN chown -R www-data:www-data /var/www/parkir-hainin \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# Jalankan php-fpm dan nginx bersamaan
COPY docker/start-hainin.sh /start-hainin.sh
RUN chmod +x /start-hainin.sh
CMD ["/start-hainin.sh"]
