<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$emailCreatore = $_SESSION['utente']['email'];
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

// controllo che progetto e profilo essistano
$progettoEsistente = $db->query(
    'SELECT nome FROM Progetto WHERE nome = :nomeProgetto AND emailCreatore = :emailCreatore',
    [':nomeProgetto' => $nomeProgetto, ':emailCreatore' => $emailCreatore]
);
$profiloEsistente = $db->query(
    'SELECT nome FROM Profilo WHERE nomeProgetto = :nomeProgetto AND nome = :nomeProfilo',
    [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);

if(!$progettoEsistente || !$profiloEsistente) {
    abort();
}

// ottengo candidature in base al filtro
$filtro = $_GET['filtro'] ?? '';

$candidature = [];

if($filtro === 'rifiutata') {
    $candidature = $db->query(
        "SELECT U.nickname, C.emailUtente, C.stato, C.accettata as risultato, C.id 
        from Candidatura C join Utente U on C.emailUtente = U.email 
        where C.nomeProfilo = :nomeProfilo and C.nomeProgetto = :nomeProgetto AND accettata = false AND stato = 'chiusa'", 
        [':nomeProfilo' => $nomeProfilo, ':nomeProgetto' => $nomeProgetto]
    );
} elseif ($filtro === 'accettata') {
    $candidature = $db->query(
        "SELECT U.nickname, C.emailUtente, C.stato, C.accettata as risultato, C.id 
        from Candidatura C join Utente U on C.emailUtente = U.email 
        where C.nomeProfilo = :nomeProfilo and C.nomeProgetto = :nomeProgetto AND accettata = true AND stato = 'chiusa'", 
        [':nomeProfilo' => $nomeProfilo, ':nomeProgetto' => $nomeProgetto]
    );
} elseif($filtro === 'aperta') {
    $candidature = $db->query(
        "SELECT U.nickname, C.emailUtente, C.stato, C.accettata as risultato, C.id 
        from Candidatura C join Utente U on C.emailUtente = U.email 
        where C.nomeProfilo = :nomeProfilo and C.nomeProgetto = :nomeProgetto AND stato = 'aperta'", 
        [':nomeProfilo' => $nomeProfilo, ':nomeProgetto' => $nomeProgetto]
    );
} else {
    $candidature = $db->query(
        "SELECT U.nickname, C.emailUtente, C.stato, C.accettata as risultato, C.id 
        from Candidatura C join Utente U on C.emailUtente = U.email 
        where C.nomeProfilo = :nomeProfilo and C.nomeProgetto = :nomeProgetto", 
        [':nomeProfilo' => $nomeProfilo, ':nomeProgetto' => $nomeProgetto]
    );
}

require view('/profilo/vedi-candidature.view.php', ['candidature' => $candidature]);
exit();