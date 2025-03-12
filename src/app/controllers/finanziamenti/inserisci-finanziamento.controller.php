<?php

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista 
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if(!$progettoEsistente) {
    abort();
}

//recupero tutte le rewards disponibili per quel progetto
$rewards = $db->query("SELECT codice, urlFoto, descr FROM Reward WHERE nomeProgetto = :nomeProgetto", [':nomeProgetto' => $nomeProgetto]);

$errori = [];

//recupero l'importo del finanziamento
$importo = $_POST['importo'];
$codice = $_POST['codice-reward'];

if(!Validatore::isNumber($importo, 1)) {
    $errori['importo'] = "L'importo deve essere un numero  maggiore di 0!";
}

if(!Validatore::isNumber($codice)) {
    $errori['codice-reward'] = "Codice reward non valido";
}

if(!empty($errori)) {
    require view('/finanziamenti/inserisci-finanziamento.view.php', ['errori' => $errori, 'rewards' => $rewards]);
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

if(!$esito) {
    $errori['procedura'] = "Impossibile finanziare il seguente progetto. Importo eccedente il budget o hai già stato inviato un finanziamento in data odierna.";
    require view('/finanziamenti/inserisci-finanziamento.view.php', ['errori' => $errori, 'rewards' => $rewards]);
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
    require view('/finanziamenti/inserisci-finanziamento.view.php', ['errori' => $errori, 'rewards' => $rewards]);
    exit();
}

header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanziamenti');
exit();