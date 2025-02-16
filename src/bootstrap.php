<?php

/**
 * bootstrap.php
 *
 * Questo file funge da bootstrap per l'applicazione, ovvero il punto di partenza in cui vengono
 * configurate e registrate le dipendenze tramite il Service Container. In questo modo, l'intera
 * applicazione può accedere centralmente ai servizi registrati.
 */

use core\App;
use core\Container;
use core\Database;

$container = new Container();

// Registra il servizio per il database, associato alla chiave "core\Database"
$container->associa('core\Database', function () {
    // Carica il file di configurazione che contiene le impostazioni per le connessioni al database
    $config = require percorso_base('config.php');

    // Crea e restituisce un'istanza della classe Database configurata per MySQL
    return new Database($config);
});

// Imposta il container globale dell'applicazione, in modo da renderlo accessibile ovunque
App::setContainer($container);
