# Use PHP Apache base image
FROM php:8.2-apache

# Set working directory to Apache's root
WORKDIR /var/www/html

# Copy only files from "public/" into Apache's root
COPY public/ /var/www/html/

# Enable Apache mod_rewrite (optional but useful)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
