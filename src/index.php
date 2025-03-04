<?php

// Definisce il percorso base del progetto
const PERCORSO_BASE = __DIR__ . '/';

// Include il file contenente funzioni di utilità
require PERCORSO_BASE.'core/functions.php';

// Registra una funzione di autoload per caricare automaticamente le classi non esplicitamente richieste con 'require'
spl_autoload_register(function ($classe) {
    // Sostituisce il namespace con il separatore di directory corretto
    $classe = str_replace('\\', DIRECTORY_SEPARATOR, $classe);
    
    // Include il file della classe richiesta utilizzando il percorso base
    require percorso_base("{$classe}.php");
});

// Inizializza il Database e lo associa al container
require percorso_base("bootstrap.php");

$router = new core\Router();

session_start();

// Carica le rotte definite nel file 'routes.php'
$routes = require percorso_base('routes.php');

// Ottiene l'URI della richiesta eliminando eventuali query string
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];


//controllo che nell'uri non sia contenuta un file dei public
$public = explode('/', $uri)[1];

// se lo è significa che sto richiedendo una route statica  e qundi uso un'altro metodo di routing
if($public === 'public') {
    $router->routeStatic($uri);
} else {
    // Determina il metodo HTTP della richiesta (override possibile tramite input nascosto)
    $metodo = isset($_POST['_metodo']) ? $_POST['_metodo'] : $_SERVER['REQUEST_METHOD'];
    // Passa l'URI e il metodo HTTP al router per la gestione della richiesta
    $router->route($uri, $metodo);
}



