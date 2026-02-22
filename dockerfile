# --- Etapa 1: Build de Assets ---
FROM node:22-alpine AS frontend-builder
WORKDIR /app

# Instalar PHP y extensiones (incluyendo las necesarias para que no chille)
RUN apk add --no-cache \
    --repository=http://dl-cdn.alpinelinux.org/alpine/edge/community \
    php84 \
    php84-cli \
    php84-common \
    php84-pdo \
    php84-pdo_pgsql \
    php84-mbstring \
    php84-xml \
    php84-openssl \
    php84-tokenizer \
    php84-curl \
    php84-phar \
    php84-session \
    php84-fileinfo \
    php84-dom \
    php84-xmlwriter \
    php84-xmlreader \
    php84-ctype \
    php84-posix \
    composer

RUN ln -sf /usr/bin/php84 /usr/bin/php

# 1. Dependencias PHP
COPY . .
COPY composer.json composer.lock ./
RUN composer install 

# 2. Dependencias Node
COPY package*.json ./
RUN npm install

# 3. Copiar código y generar autoloader (SIN SCRIPTS para evitar el error de Pail)

ENV APP_ENV=production

# 4. Build de Assets (Wayfinder ahora funcionará porque el autoloader existe)
RUN npm run build

# --- Etapa 2: FrankenPHP ---
# (Asegúrate de copiar el vendor y el build correctamente)
FROM dunglas/frankenphp:latest-php8.4-alpine

RUN install-php-extensions \
    pcntl \
    bcmath \
    gd \
    intl \
    pdo_pgsql \
    zip \
    opcache \
    redis

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiamos todo el código
COPY . .

# Sobrescribimos el vendor y el build con lo procesado en la etapa 1 para ahorrar tiempo
COPY --from=frontend-builder /app/vendor ./vendor
COPY --from=frontend-builder /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

ENV FRANKENPHP_CONFIG="worker ./public/index.php"

EXPOSE 80
ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80"]