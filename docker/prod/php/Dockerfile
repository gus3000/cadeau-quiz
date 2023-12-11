FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

RUN apt-get install -y supervisor
RUN docker-php-ext-install pdo pdo_mysql bcmath

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
