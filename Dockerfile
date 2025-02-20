FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y libssl-dev

RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN npm install

RUN a2enmod rewrite

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
