FROM php:8.1-apache

# Installa le dipendenze necessarie
RUN apt-get update \
    && apt-get install -y --no-install-recommends openssl libssl-dev libcurl4-openssl-dev\
    && pecl install mongodb \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && chown -R www-data:www-data /var/www/html

# Copia tutti i file del progetto
COPY ./src /var/www/html/

WORKDIR /var/www/html