<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$email = $_SESSION['utente']['email'];
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

// controllo che progetto e profilo essistano
$progettoEsistente = $db->query(
    'SELECT nome FROM Progetto WHERE nome = :nomeProgetto',
    [':nomeProgetto' => $nomeProgetto]
);
$profiloEsistente = $db->query(
    'SELECT nome FROM Profilo WHERE nomeProgetto = :nomeProgetto AND nome = :nomeProfilo',
    [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);

if(!$progettoEsistente || !$profiloEsistente) {
    abort();
}

$parametri = [
        'nomeProfiloI' => $nomeProfilo,
        'nomeProgettoI' => $nomeProgetto,
        'emailUtenteI' => $email,
        '@esito' => '@esito'
];
$esito = $db->procedure("InserimentoCandidatura", $parametri);
    
//se l'esito è negativo, mostro un errore nella vista
if ($esito === 0) {
    AlertManager::setError("Non disponi di tutti i livelli skill minimi richiesti dal profilo.");
} elseif ($esito === 1) {
    AlertManager::setSuccess("Candidatura inviata con successo!");
    $db_mongo->inserisciLog("Nuova candidatura effettuata da ".$email." per il profilo ".$nomeProfilo." del progetto ".$nomeProgetto);
} elseif ($esito === 2) {
    AlertManager::setWarning("Hai già inviato una candidatura per questo profilo che non è stata ancora visionata.");
} else {
    AlertManager::setWarning("Hai già inviato una candidatura per questo profilo che è già stata accettata.");
}

header("location: /home/progetti/".$nomeProgetto."/profili");
exit();
