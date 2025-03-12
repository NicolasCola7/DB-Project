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
$finaziamentoEsistente = $db->query("SELECT * FROM Finanziamento WHERE nomeProgetto = :nomeProgetto AND emailUtente = :email AND data = current_date()", [':nomeProgetto' => $nomeProgetto, ':email' => $email]);

if(!$progettoEsistente || !$finaziamentoEsistente) {
    abort();
}

//recupero tutte le rewards disponibili per quel progetto
$rewards = $db->query("SELECT codice, urlFoto, descr FROM Reward WHERE nomeProgetto = :nomeProgetto", [':nomeProgetto' => $nomeProgetto]);

require view('/finanziamenti/scelta-reward.view.php', $rewards);
exit();