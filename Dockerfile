# Use the official PHP 8.0 image from Docker Hub
FROM php:8.2-apache

# Install the PHP PDO extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy the application files to the Docker image
COPY . /var/www/html

# Use the default development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]