# ===== Dockerfile - Aplikasi Parkir [ANDI] =====
FROM php:8.2-fpm
 
LABEL maintainer="ANDI - SIJA XI"
 
# Install dependency sistem & ekstensi PHP
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
 
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
 
WORKDIR /var/www/parkir-andi
COPY . .
 
# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader
 
# Copy konfigurasi Nginx custom
COPY docker/nginx-andi.conf /etc/nginx/sites-available/default
 
# Permission storage & cache
RUN chown -R www-data:www-data /var/www/parkir-andi \
    && chmod -R 775 storage bootstrap/cache
 
EXPOSE 80
 
# Jalankan php-fpm dan nginx bersamaan
COPY docker/start-andi.sh /start-andi.sh
RUN chmod +x /start-andi.sh
CMD ["/start-andi.sh"]
