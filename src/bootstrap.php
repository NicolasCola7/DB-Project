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
use core\MySqlDatabase;

$container = new Container();

// Registra il servizio per il MySqlDatabase, associato alla chiave "core\MySqlDatabase"
$container->associa('core\MySqlDatabase', function () {
    // Carica il file di configurazione che contiene le impostazioni per le connessioni al MySqlDatabase
    $config = require percorso_base('config.php');

    // Crea e restituisce un'istanza della classe MySqlDatabase configurata per MySQL
    return new MySqlDatabase($config);
});

// Imposta il container globale dell'applicazione, in modo da renderlo accessibile ovunque
App::setContainer($container);
