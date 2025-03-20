<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
// ottendo id commento
$idCommento = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

// controllo che progetto e commento esistano e che quest'ultimo non abbia già una risposta
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome",
    [':nome' => $nomeProgetto]
);
$commentoEsistente = $db->query(
    "SELECT id FROM Commento WHERE id = :id AND nomeProgetto = :nome",
    [':id' => $idCommento, ':nome' => $nomeProgetto]
);
$conRisposta = $db->query(
    "SELECT * FROM Risposta WHERE idCommento = :id",
    [':id' => $idCommento]
);

if(!$progettoEsistente || !$commentoEsistente || $conRisposta) {
    abort();
}

$commento = $db->query(
    "SELECT U.nickname, C.id, C.data, C.testo as commento, R.contenuto as risposta 
    from Commento C left join Risposta R on C.id = R.idCommento join Utente U on C.emailUtente = U.email 
     where C.nomeProgetto = :nomeProgetto and C.id = :id",
    [':nomeProgetto' => $nomeProgetto, ':id' => $idCommento]
)[0];

require view(
    '/commenti/rispondi-commento.view.php',
    ['commento' => $commento]
);
exit();