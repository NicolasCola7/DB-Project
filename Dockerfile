FROM php:8.1-apache

# Abilita il modulo rewrite, se necessario
RUN a2enmod rewrite

# Installa le estensioni PDO e pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Copia i file della tua applicazione (modifica il percorso in base alla tua struttura)
COPY ./testing /var/www/html/testing

# Imposta i permessi corretti (opzionale ma consigliato)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Espone la porta 80 per Apache
EXPOSE 80

# Avvia Apache in modalità foreground
CMD ["apache2-foreground"]
