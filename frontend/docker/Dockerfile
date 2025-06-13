FROM php:8.3-fpm

RUN apt-get update && apt-get install -y nginx

COPY ./nginx.conf /etc/nginx/sites-available/default

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80

CMD service php8.3-fpm start && nginx -g 'daemon off;'
