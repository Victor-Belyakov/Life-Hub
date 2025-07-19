FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_pgsql

# Настройка Xdebug
COPY frontend/docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


COPY /frontend/docker/nginx.conf /etc/nginx/sites-available/default

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80
