FROM php:8.1-apache

RUN apt-get update -y && apt-get install -y zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./www /var/www/html

WORKDIR /var/www/html

RUN composer install

EXPOSE 80