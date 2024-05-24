# Use the official PHP 8.0 image from Docker Hub
FROM php:8.3-apache

# Install the PHP PDO extension
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_current.x | bash -
RUN apt-get install -y nodejs

# Install specific npm version
RUN npm install -g npm@10.4.0

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application files to the Docker image
COPY . /var/www/html

# Install Composer dependencies
RUN composer install

# Install npm dependencies
RUN npm install

# Set necessary permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache  # Corrected here

# Use the default development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Expose port 8000
EXPOSE 8000

# Start Apache and Laravel server
CMD ["sh", "-c", "apache2-foreground"]