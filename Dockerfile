FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

# Install dependencies
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    git \
    unzip

# Install MongoDB PHP Driver
RUN pecl install mongodb && \
    echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongodb.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html