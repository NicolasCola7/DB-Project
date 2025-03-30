FROM php:8.1-apache

# Aggiornamento lista pacchetti.
# Installazione delle dipendenze:
#   - openssl: per la crittografia.
#   - libssl-dev: librerie SSL per lo sviluppo.
#   - libcurl4-openssl-dev: librerie cURL per HTTPS.
# Installazione dell'estensione MongoDB tramite PECL.
# Installazione delle estensioni PHP:
#   - pdo e pdo_mysql per la gestione dei database.
# Abilitazione dell'estensione MongoDB.
# Abilitazione del modulo rewrite di Apache.
# Pulizia della cache di apt-get e rimozione delle liste pacchetti per ridurre il peso dell'immagine.
# Modifica della configurazione di Apache per permettere override tramite file .htaccess.
# Impostazione dei permessi corretti per la directory /var/www/html.
RUN apt-get update \
    && apt-get install -y --no-install-recommends openssl libssl-dev libcurl4-openssl-dev \
    && pecl install mongodb \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && chown -R www-data:www-data /var/www/html

# Copia tutti i file del progetto nella directory di Apache
COPY ./src /var/www/html/

WORKDIR /var/www/html
