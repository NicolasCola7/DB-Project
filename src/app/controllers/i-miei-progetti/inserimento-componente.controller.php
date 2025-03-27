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

// controllo che il progetto esista e siahardware
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome AND tipoProgetto = 'Hardware' AND emailCreatore = :email",
     [':nome' => $nomeProgetto, ':email' => $email]
);

if(!$progettoEsistente) {
    abort();
}
$nome = $_POST['nome'];
$descrizione = $_POST['descrizione'];
$quantita = $_POST['quantita'];
$prezzo = $_POST['prezzo'];

if (!Validatore::isString($nome, 1, 50)) {
    AlertManager::setError("nome", "Nome del componente non valido");
}

if (!Validatore::isString($descrizione, 1, 100)) {
    AlertManager::setError("descrizione", "Descrizione non valida o troppo lunga!");
}

if (!Validatore::isNumber($quantita, 1)) {
    AlertManager::setError("quantita", "La quantità minima deve essere 1!");
}

if (!Validatore::isNumber($prezzo, 1)) {
    AlertManager::setError("prezzo", "Il prezzo minimo deve essere 1!");
}

if (!empty($_SESSION['errore'])) {
    header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto).'/aggiungi-componente');
    exit();
}

$paramsComponente = [
    'nomeComponente' => $nome,
    'nomeProgetto' => $nomeProgetto,
    'descrizione' => $descrizione,
    'prezzo' => $prezzo,
    'quantita' => $quantita,
    '@esito' => '@esito'
];

$esito = $db->procedure('InserimentoComponenteHardware', $paramsComponente);

if (!$esito) {
    AlertManager::setError('procedura', "Si è verificato un errore imprevisto nell'inserimento della componente hardware!");
    header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto).'/aggiungi-componente');
    exit();
}

$db_mongo->inserisciLog("Nuova componente ".$nome." inserita per il progetto ".$nomeProgetto);
AlertManager::setSuccess("Componente aggiunta.");
header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto));
exit();