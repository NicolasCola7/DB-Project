<?php

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista e che sia stato inserito appena un finanziamento ad esso
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);
$finaziamentoEsistente = $db->query("SELECT * FROM Finanziamento WHERE nomeprogetto = :nomeProgetto AND emailUtente = :email AND data = current_date()", [':nomeProgetto' => $nomeProgetto, ':email' => $email]);

if(!$progettoEsistente || !$finaziamentoEsistente) {
    abort();
}

$errori = [];

//recupero l'codice-reward del finanziamento
$codice = $_POST['codice-reward'];

if(!Validatore::isNumber($codice)) {
    $errori['codice-reward'] = "Codice reward non valido";
    require view('/finanziamenti/inserisci-finanziamento.view.php', $errori);
    exit();
}

$parametri = [
    'codiceReward' => $codice,
    'emailUtente' => $email,
    'nomeProgetto' => $nomeProgetto,
    '@esito' => '@esito'
];

$esito = $db->procedure('SceltaReward', $parametri);

if(!$esito) {
    $errori['procedura'] = "Si è verificato un'errore nella scelta della reward, riprova.";
    require view('/finanziamenti/inserisci-finanziamento.view.php', $errori);
    exit();
}


header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanziamenti');
exit();