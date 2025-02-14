<?php

// Definisce il percorso base del progetto
const BASE_PATH = __DIR__.'/../';

// Include il file contenente funzioni di utilità
require BASE_PATH.'app/functions.php';

// Registra una funzione di autoload per caricare automaticamente le classi richieste
spl_autoload_register(function ($class) {
    // Sostituisce il namespace con il separatore di directory corretto
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Include il file della classe richiesta utilizzando il percorso base
    require base_path("{$class}.php");
});

// Crea un'istanza della classe Router
$router = new \app\Router();

// Carica le rotte definite nel file 'routes.php'
$routes = require base_path('routes.php');

// Ottiene l'URI della richiesta eliminando eventuali query string
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// Determina il metodo HTTP della richiesta (override possibile tramite input nascosto)
$method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

// Passa l'URI e il metodo HTTP al router per la gestione della richiesta
$router->route($uri, $method);


