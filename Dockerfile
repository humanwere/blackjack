FROM php:8.0.5-fpm-alpine
# Install system dependencies 2
RUN apk update
RUN apk upgrade
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

USER www-data:www-data
WORKDIR /var/www/php
COPY --chown=www-data . /var/www/php

RUN composer install
RUN composer dumpautoload
