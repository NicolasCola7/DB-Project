<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];

$_SESSION['utente']['progetti'] = $db->query("SELECT P.nome AS NomeProgetto, U.nome AS NomeCreatore, U.cognome, P.stato FROM Progetto P join Utente U on P.emailCreatore = U.email");

header("Location: /home/visualizza-progetti");
exit;