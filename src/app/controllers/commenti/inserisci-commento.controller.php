<?php

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista 
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if(!$progettoEsistente) {
    abort();
}

$errori = [];

//recupero il testo del commento
$testo = $_POST['testo'];

if(!Validatore::isString($testo, 1)) {
    $errori['testo'] = 'Devi inserire un testo di lunghezza maggiore di 1!';
    require view('/commenti/inserisci-commento.view.php', $errori);
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
    $errori['procedura'] = "Si è verificato un errore nell'invio del commento, riprova.";
    require view('/commenti/inserisci-commento.view.php', $errori);
    exit();
}

require view('/commenti/inserisci-commento.view.php', ['successo' => $successo = true]);
exit();