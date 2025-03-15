<?php

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$emailCreatore = $_SESSION['utente']['email'];
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);
$idCandidatura = urldecode(explode('/', $_SERVER['REQUEST_URI'])[7]);

// controllo che progetto, profilo  e candidatura esistano
$progettoEsistente = $db->query(
    'SELECT nome FROM Progetto WHERE nome = :nomeProgetto AND emailCreatore = :emailCreatore',
    [':nomeProgetto' => $nomeProgetto, ':emailCreatore' => $emailCreatore]
);
$profiloEsistente = $db->query(
    'SELECT nome FROM Profilo WHERE nomeProgetto = :nomeProgetto AND nome = :nomeProfilo',
    [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);
$candidaturaEsistente = $db->query(
    "SELECT id FROM Candidatura WHERE id = :id AND nomeProgetto = :nomeProgetto AND nomeProfilo = :nomeProfilo",
    [':id' => $idCandidatura, ':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);

if(!$progettoEsistente || !$profiloEsistente || !$candidaturaEsistente) {
    abort();
}

//ottengo la mail dell'utente candidato
$emailCandidato = $db->query(
    "SELECT emailUtente FROM Candidatura WHERE id = :id",
    [':id' => $idCandidatura]
)[0]['emailUtente'];

//recupero la scelta dell'utente creatore
$scelta = $_GET['scelta'] ?? '';
$scelta = ($scelta === 'rifiuta' ? 0 : 1);

$parametri = [
    'nomeProfiloI' => $nomeProfilo,
    'nomeProgettoI' => $nomeProgetto,
    'emailUtenteI' => $emailCandidato,
    'sceltaCreatoreI' => $scelta,
    '@esito' => '@esito'
];

$esito = $db->procedure("checkCandidatura", $parametri);
$scelta = ($scelta === 0 ? "rifiuto" : "approvazione");

//se l'esito è negativo, mostro un errore nella vista
if(!$esito){
    $_SESSION["utente"]["errore_validazione"] = "L'operazione di ".$scelta." non è andata a buon fine.";
    unset($_SESSION['utente']['esito_validazione']); 
} else {
    $_SESSION['utente']['esito_validazione'] = "Operazione di ".$scelta." avvenuta con successo.";
    unset($_SESSION['utente']['errore_validazione']);
}

header("location: /home/i-miei-progetti/".urlencode($nomeProgetto)."/profili/".urlencode($nomeProfilo)."/candidature");
exit();
 