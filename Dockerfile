FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy contents of public into Apache web root
COPY public/ /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
