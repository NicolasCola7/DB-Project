<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

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
    AlertManager::setError("procedura", "operazione di ".$scelta." non è andata a buon fine.");
} else {
    AlertManager::setSuccess("Operazione di ".$scelta." avvenuta.");
    $scelta = ($scelta === 'rifiuto' ? "rifiutata" : "approvata");
    $db_mongo->inserisciLog("Candidatura ".$idCandidatura." al profilo ".$nomeProfilo." del progetto ".$nomeProgetto. " ".$scelta);
}

header("location: /home/i-miei-progetti/".urlencode($nomeProgetto)."/profili/".urlencode($nomeProfilo)."/candidature");
exit();
 