# --- Etapa 1: Build de Assets (Mantenemos tu lógica corregida) ---
FROM node:22-alpine AS frontend-builder
WORKDIR /app

RUN apk add --no-cache \
    --repository=http://dl-cdn.alpinelinux.org/alpine/edge/community \
    php84 php84-cli php84-common php84-pdo php84-pdo_pgsql php84-mbstring \
    php84-xml php84-openssl php84-tokenizer php84-curl php84-phar \
    php84-session php84-fileinfo php84-dom php84-xmlwriter php84-xmlreader \
    php84-ctype php84-posix composer

RUN ln -sf /usr/bin/php84 /usr/bin/php

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

COPY package*.json ./
RUN npm install

COPY . .
RUN rm -rf bootstrap/cache/*.php && \
    sed -i '/Laravel\\Sail/d' bootstrap/providers.php 2>/dev/null || true && \
    sed -i '/Laravel\\Pail/d' bootstrap/providers.php 2>/dev/null || true

RUN composer install
RUN npm run build

# --- Etapa 2: FrankenPHP (EL FIX) ---
FROM dunglas/frankenphp:php8.4-alpine
RUN install-php-extensions pcntl bcmath gd intl pdo_pgsql zip opcache redis

WORKDIR /app

# Variables de entorno críticas
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

COPY . .
COPY --from=frontend-builder /app/vendor ./vendor
COPY --from=frontend-builder /app/public/build ./public/build

# Aseguramos permisos correctos para el usuario de FrankenPHP
RUN chown -R www-data:www-data storage bootstrap/cache public

# Limpiamos caché de configuración para que no use rutas del builder
RUN php artisan config:clear && php artisan route:clear

# FrankenPHP necesita este permiso para el binario interno si usa octane
USER www-data

EXPOSE 80
# Forzamos el directorio de trabajo
WORKDIR /app
# Usamos un Entrypoint que nos permita ver errores si falla
# ... resto del Dockerfile ...

# Agregamos --admin-port=2019 al final
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80", "--admin-port=2019", "--no-interaction"]