FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
# Ensure Apache allows .htaccess overrides.
# This command updates Apache’s main config to allow .htaccess files in /var/www/html.
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy your application files (including index.php and optionally an .htaccess file)
COPY ./src /var/www/html/