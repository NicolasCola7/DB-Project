<?php

use \core\App;
use \core\Database;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];

$progetti = $db->query("SELECT P.nome AS NomeProgetto, P.stato, MIN(FP.urlImmagine) AS urlImmagine
    FROM Progetto AS P
    JOIN Utente AS U ON P.emailCreatore = U.email
    LEFT JOIN Foto_Progetto AS FP ON P.nome = FP.nomeProgetto
    WHERE emailCreatore = :email
    GROUP BY P.nome, U.nome, U.cognome, P.stato;
", [':email' => $email]);

require view('/i-miei-progetti/i-miei-progetti.view.php', ['progetti' => $progetti]);
exit;