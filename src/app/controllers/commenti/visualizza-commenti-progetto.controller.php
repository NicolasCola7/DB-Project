<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome",
    [':nome' => $nomeProgetto]
);

if(!$progettoEsistente) {
    abort();
}

$commenti = $db->query(
    "SELECT U.nickname, C.id, C.data, C.testo as commento, R.contenuto as risposta
     from Commento C left join Risposta R on C.id = R.idCommento join Utente U on C.emailUtente = U.email 
     where C.nomeProgetto = :nomeProgetto order by C.id desc",
    [':nomeProgetto' => $nomeProgetto]
);
$emailCreatore = $db->query("SELECT emailCreatore from Progetto where nome = :nomeProgetto", [':nomeProgetto' => $nomeProgetto])[0]['emailCreatore'];
require view('/commenti/visualizza-commenti-progetto.view.php', ['commenti' => $commenti, 'emailCreatore' => $emailCreatore]);
exit();