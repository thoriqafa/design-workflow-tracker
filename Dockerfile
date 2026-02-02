# Stage 1: Build frontend assets
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Build backend dependencies
FROM composer:2 AS composer_build
WORKDIR /app
COPY composer.json composer.lock ./
# --no-dev: Install only production dependencies
# --optimize-autoloader: Generate optimized autoloader
# --no-interaction: Do not ask any interactive question
# --prefer-dist: Download packages dist (zip) if possible
# --no-scripts: Do not execute scripts defined in composer.json
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts --ignore-platform-reqs

# Stage 3: Final application image
FROM php:8.3-apache AS app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
    pdo_mysql \
    mysqli \
    zip \
    gd \
    mbstring \
    intl \
    opcache \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite

# Configure PHP & Apache
COPY docker_config/php/php.ini /usr/local/etc/php/conf.d/custom-php.ini
COPY docker_config/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker_config/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Copy vendor libraries from composer stage
COPY --from=composer_build /app/vendor ./vendor

# Copy frontend assets from frontend stage
# Assuming Vite build output is in public/build
COPY --from=frontend /app/public/build ./public/build

# Setup file permissions
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache \
    && chmod -R 775 \
    storage \
    bootstrap/cache

# Setup entrypoint
COPY docker_config/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Switch to non-root user?
# Apache default runs as root then spawns www-data workers.
# For entrypoint migration we usually stick to root or switch in the script.
# Sticking with default Apache behavior but ensuring ownership is correct.

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
