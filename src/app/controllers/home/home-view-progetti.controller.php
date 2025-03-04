<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];

$_SESSION['utente']['progetti'] = $db->query("SELECT P.nome AS NomeProgetto, U.nome AS NomeCreatore, U.cognome, P.stato, FP.percorsoImmagine
    FROM Progetto P
    JOIN Utente U ON P.emailCreatore = U.email
    LEFT JOIN Foto_Progetto FP ON P.nome = FP.nomeProgetto
");

header("Location: /home/visualizza-progetti");
exit;