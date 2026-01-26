# Base PHP image + extensions
FROM php:8.3-apache AS base

# System dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
    libonig-dev libxml2-dev \
    libicu-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install pdo pdo_mysql mysqli zip gd mbstring intl \
 && rm -rf /var/lib/apt/lists/*

# Apache configuration
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
 && a2enmod rewrite \
 && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
RUN printf "upload_max_filesize=100M\npost_max_size=120M\n" \
  > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html
EXPOSE 80


# Composer dependencies build stage
FROM composer:2 AS composer_build

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --no-scripts


# Vite / NPM build stage
FROM node:20-bookworm-slim AS vite_build

WORKDIR /app

# Copy only npm files first (cache friendly)
COPY package.json package-lock.json ./
RUN npm ci

# Copy full source
COPY . .

# Build Vite assets
RUN npm run build


# Final application image
FROM base AS app

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Copy application source
COPY . .

# Copy vendor from composer stage
COPY --from=composer_build /app/vendor ./vendor

# Copy built Vite assets
COPY --from=vite_build /app/public/build ./public/build

# Laravel storage/cache permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
 && find storage bootstrap/cache -type d -exec chmod 775 {} \; \
 && find storage bootstrap/cache -type f -exec chmod 664 {} \;

# Create storage symlink (aman kalau sudah ada)
RUN php artisan storage:link || true

# Start container
CMD ["sh", "-c", "\
php artisan migrate --force --no-interaction && \
php artisan config:clear && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
apache2-foreground"]
