FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

COPY /frontend/docker/nginx.conf /etc/nginx/sites-available/default

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80

