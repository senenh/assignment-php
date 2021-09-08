FROM php:7.4.20-fpm-buster

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html/app

RUN set -eux \
   && apt-get update \
   && apt-get install -y libzip-dev zlib1g-dev \
   && docker-php-ext-install zip
