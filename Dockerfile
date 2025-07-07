FROM php:8.2-apache

RUN a2enmod rewrite

COPY public/ /var/www/html/

WORKDIR /var/www/html/

EXPOSE 80
