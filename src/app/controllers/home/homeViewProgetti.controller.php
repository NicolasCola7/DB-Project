<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];

//TODO: da implementare la logica per ottenere i progetti

header("Location: /home/visualizzaProgetti");
exit;