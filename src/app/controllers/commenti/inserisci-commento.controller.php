<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\Validatore;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista 
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if(!$progettoEsistente) {
    abort();
}

//controllo che l'utente non sia il creatore di quel progetto
$nonCreatore = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome AND emailCreatore != :email",
     [':nome' => $nomeProgetto, ':email' => $email]
);

if(!$nonCreatore) {
    AlertManager::setError('creatore', 'Non puoi commentare un progetto che hai creato!');
    header('location: /home/progetti/'.$nomeProgetto."/commenta");
    exit();
}

//recupero il testo del commento
$testo = $_POST['testo'];

if(!Validatore::isString($testo, 1)) {
    AlertManager::setError('testo', 'Devi inserire un testo di lunghezza maggiore di 1!');
    header('location: /home/progetti/'.$nomeProgetto."/commenta");
    exit();
}

$parametri = [
    'nomeProgetto' => $nomeProgetto,
    'emailUtente' => $email,
    'testo' => $testo,
    '@esito' => '@esito'
];

$esito = $db->procedure('CommentaProgetto', $parametri);

if(!$esito) {
    AlertManager::setError('procedura', "Si è verificato un errore nell'invio del commento, riprova.");
    header('location: /home/progetti/'.$nomeProgetto."/commenta");
    exit();
}

$db_mongo->inserisciLog("Nuovo commento pubblicato da ".$email." nel progetto ".$nomeProgetto);
AlertManager::setSuccess("Messaggio inviato.");
header("location: /home/progetti/".urlencode($nomeProgetto)."/commenti");
exit();