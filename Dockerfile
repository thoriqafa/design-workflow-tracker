# =========================
# Base PHP image + extensions
# =========================
FROM php:8.3-apache AS base

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
    libonig-dev libxml2-dev \
    libicu-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install pdo pdo_mysql mysqli zip gd mbstring intl \
 && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
      /etc/apache2/sites-available/000-default.conf \
      /etc/apache2/apache2.conf \
 && a2enmod rewrite \
 && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY docker/8.2/php.ini /usr/local/etc/php/conf.d/custom.ini
RUN printf "upload_max_filesize=100M\npost_max_size=120M\n" \
  > /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
EXPOSE 80


# =========================
# Composer build stage
# =========================
FROM base AS composer_build

WORKDIR /app

# Copy full source (WAJIB untuk Laravel autoload & helpers)
COPY . .

# Folder wajib Laravel saat composer jalan
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# =========================
# Vite / Node build stage
# =========================
FROM node:20-bookworm-slim AS vite_build

WORKDIR /app
RUN corepack enable

COPY package.json yarn.lock ./
RUN yarn install --frozen-lockfile

COPY . .
RUN yarn build


# =========================
# Final application image
# =========================
FROM base AS app

ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /var/www/html

# Copy source
COPY . .

# Copy vendor & built assets
COPY --from=composer_build /app/vendor ./vendor
COPY --from=vite_build /app/public/build ./public/build

# Folder wajib Laravel di runtime
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Bersihkan cache yang mungkin ikut ter-copy
RUN rm -rf bootstrap/cache/*

# Permission yang benar
RUN chown -R www-data:www-data storage bootstrap/cache \
 && find storage bootstrap/cache -type d -exec chmod 775 {} \; \
 && find storage bootstrap/cache -type f -exec chmod 664 {} \;

RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage || true


# =========================
# Startup sequence (tanpa entrypoint)
# =========================
CMD sh -c "php artisan config:clear && \
php artisan cache:clear && \
php artisan route:clear && \
php artisan view:clear && \
php artisan storage:link || true && \
php artisan migrate --force --no-interaction && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
exec apache2-foreground"
