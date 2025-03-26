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

$errori = [];

//recupero l'importo del finanziamento
$importo = $_POST['importo'];
$codice = $_POST['codice-reward'];

if(!Validatore::isNumber($importo, 0)) {
    $errori['importo'] = "L'importo deve essere un numero  maggiore di 0!";
}

if(!Validatore::isNumber($codice)) {
    $errori['codice-reward'] = "Codice reward non valido";
}

if(!empty($errori)) {
    require view('/finanziamenti/inserisci-finanziamento.view.php');
    
    AlertManager::setError("Oggi hai già inviato un finanziamento per questo progetto.");
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

if($esito == 0) 
{
    $errori['procedura'] = "L'importo inserito non è corretto!";
    require view('/finanziamenti/inserisci-finanziamento.view.php');
    exit();
}
else if($esito == 1)
{
    $errori['procedura'] = "Hai già eseguito un finanziamento per il progetto ".$nomeProgetto." in data odierna!";
    require view('/finanziamenti/inserisci-finanziamento.view.php');
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
    $errori['procedura'] = "Si è verificato un'errore nella scelta della reward, riprova.";
    require view('/finanziamenti/inserisci-finanziamento.view.php');
    exit();
}

$db_mongo->inserisciLog('Nuovo finanziamento effettuato da '.$email.' per il progetto '.$nomeProgetto);

AlertManager::setSuccess("Finanziamento eseguito.");
header("location: /home/progetti");
exit();