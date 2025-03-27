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

//recupero l'importo del finanziamento
$importo = $_POST['importo'];
$codice = $_POST['codice-reward'];

if(!Validatore::isNumber($importo, 0)) {
    AlertManager::setError('importo', "L'importo deve essere un numero  maggiore di 0!");
}

if(!Validatore::isNumber($codice)) {
    AlertManager::setError('codice-reward', "Codice reward non valido");
}

if(!empty($_SESSION['errore'])) {
    header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanzia');
    exit();
}

//invio finanziamento
$parametriFinanziamento = [
    'nomeProgetto' => $nomeProgetto,
    'importo' => $importo,
    'emailUtente' => $email,
    '@esito' => '@esito'
];

$esito = $db->procedure('InserimentoFinanziamento', $parametriFinanziamento);

if($esito == 0) {
    AlertManager::setError('procedura', "L'importo inserito non è corretto!");
    header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanzia');
    exit();
} else if($esito == 1) {
    AlertManager::setError('procedura', "Hai già eseguito un finanziamento per il progetto ".$nomeProgetto." in data odierna!");
    header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanzia');
    exit();
}

// inserimento reward scelta
$parametriReward = [
    'codiceReward' => $codice,
    'emailUtente' => $email,
    'nomeProgetto' => $nomeProgetto,
    '@esito' => '@esito'
];

$esito = $db->procedure('SceltaReward', $parametriReward);

if(!$esito) {
    AlertManager::setError('procedura', "Si è verificato un'errore nella scelta della reward, riprova.");
    header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanzia');
    exit();
}

$db_mongo->inserisciLog('Nuovo finanziamento effettuato da '.$email.' per il progetto '.$nomeProgetto);

AlertManager::setSuccess("Finanziamento eseguito.");
header("location: /home/i-miei-finanziamenti");
exit();