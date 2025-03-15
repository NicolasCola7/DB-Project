<?php

use \core\App;
use \core\Database;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];
$progetti = [];

// se il controller è richiesto dalla sezione i-miei-progetti mostro solo quelli creati dall'utente creatore
if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti') {
    $progetti = $db->query(
        "SELECT P.nome AS NomeProgetto, U.nickname AS nickname, P.stato, MIN(FP.urlImmagine) AS urlImmagine
        FROM Progetto AS P
        JOIN Utente AS U ON P.emailCreatore = U.email
        LEFT JOIN Foto_Progetto AS FP ON P.nome = FP.nomeProgetto
        GROUP BY P.nome, U.nickname, P.stato;",
    );
} else {
    $progetti = $db->query(
        "SELECT P.nome AS NomeProgetto, U.nickname AS nickname, P.stato, MIN(FP.urlImmagine) AS urlImmagine
        FROM Progetto AS P
        JOIN Utente AS U ON P.emailCreatore = U.email
        LEFT JOIN Foto_Progetto AS FP ON P.nome = FP.nomeProgetto
        WHERE emailCreatore = :email
        GROUP BY P.nome, U.nome, U.cognome, P.stato;",
        [':email' => $email]);
}

require view('/progetti/vedi-progetti.view.php', ['progetti' => $progetti]);
exit;