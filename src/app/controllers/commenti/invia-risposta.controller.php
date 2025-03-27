<?php
use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\AlertManager;
use \core\Validatore;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
// ottendo id commento
$idCommento = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

// controllo che progetto e commento esistano
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome",
    [':nome' => $nomeProgetto]
);
$commentoEsistente = $db->query(
    "SELECT id FROM Commento WHERE id = :id AND nomeProgetto = :nome",
    [':id' => $idCommento, ':nome' => $nomeProgetto]
);

if(!$progettoEsistente || !$commentoEsistente) {
    abort();
}

//recupero il testo della risposta
$testo = $_POST['contenuto'];

if(!Validatore::isString($testo, 1)) {
    AlertManager::setError('testo', 'Devi inserire un testo di lunghezza maggiore di 1!');
    header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto).'/commenti/'.$idCommento.'/rispondi');
    exit();
}

// Definizione dei parametri per la procedura di autenticazione nel MySqlDatabase
$parametri = [
    'idCommentoI' => $idCommento,
    'contenutoI' => $testo,
    'emailCreatoreI' => $_SESSION['utente']['email'],
    '@esito' => '@esito' 
];

$esito = $db->procedure("rispondiACommento", $parametri);

//se l'esito è negativo, mostro un errore nella vista
if(!$esito){
     AlertManager::setError("errore_risposta", "L'operazione di invio della risposta non è andata a buon fine.");
     header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto).'/commenti/'.$idCommento.'/rispondi');
     exit();
} 

AlertManager::setSuccess("L'operazione di invio della risposta è andata a buon fine.");
$db_mongo->inserisciLog("Risposta pubblicata da ".$_SESSION['utente']['email']." nel progetto ".$nomeProgetto." al commento ".$idCommento);
header("location: /home/i-miei-progetti/".urlencode($nomeProgetto)."/commenti");
exit();
