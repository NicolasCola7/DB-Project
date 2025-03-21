<?php

use \core\App;
use \core\MySqlDatabase;

// Ottiene un'istanza della classe MySqlDatabase dal container dell'applicazione
$db = App::getContainer()->risolvi(MySqlDatabase::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];
$progetti = [];

// se il controller è richiesto dalla sezione i-miei-progetti mostro solo quelli creati dall'utente creatore
if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti') {
    $progetti = $db->query(
        "SELECT P.nome AS NomeProgetto, U.nickname, P.stato, MIN(FP.urlImmagine) AS urlImmagine, COALESCE(SUM(F.importo), 0) / P.budget_avvio AS avanzamento
        FROM Progetto AS P
        JOIN Utente AS U ON P.emailCreatore = U.email
        LEFT JOIN Foto_Progetto AS FP ON P.nome = FP.nomeProgetto
        LEFT JOIN Finanziamento F ON P.nome = F.nomeProgetto
        GROUP BY P.nome, U.nickname, P.stato, P.budget_avvio;"
    );
} 
else 
{
    $progetti = $db->query(
        "SELECT P.nome AS NomeProgetto, U.nickname, P.stato, MIN(FP.urlImmagine) AS urlImmagine, COALESCE(SUM(F.importo), 0) / P.budget_avvio AS avanzamento
        FROM Progetto AS P
        JOIN Utente AS U ON P.emailCreatore = U.email
        LEFT JOIN Foto_Progetto AS FP ON P.nome = FP.nomeProgetto
        LEFT JOIN Finanziamento F ON P.nome = F.nomeProgetto
        WHERE emailCreatore = :email
        GROUP BY P.nome, U.nickname, P.stato, P.budget_avvio;",
        [':email' => $email]);
}
require view('/progetti/vedi-progetti.view.php', ['progetti' => $progetti]);
exit;