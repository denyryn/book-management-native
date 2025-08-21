FROM php:8.4-apache

# Install mysqli and pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module (optional, for routing)
RUN a2enmod rewrite

# Copy app code (optional, if not using volumes)
# COPY . /var/www/html/
