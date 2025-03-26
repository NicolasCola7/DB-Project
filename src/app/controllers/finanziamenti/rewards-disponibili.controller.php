<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
// controllo che il progetto esista e che sia stato inserito appena un finanziamento ad esso
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if(!$progettoEsistente) {
    abort();
}

//recupero tutte le rewards disponibili per quel progetto
$rewards = $db->query("SELECT codice, urlFoto, descr FROM Reward WHERE nomeProgetto = :nomeProgetto", [':nomeProgetto' => $nomeProgetto]);

//ottengo la percentuale di avanzamento del progetto sui finanziamenti ricevuti

$valori = $db->query("SELECT P.budget_avvio, COALESCE(SUM(F.importo), 0) AS sommaRicevuta, COALESCE(SUM(F.importo), 0) / P.budget_avvio AS avanzamento
                        FROM Progetto P LEFT JOIN Finanziamento F ON P.nome = F.nomeProgetto 
                        WHERE P.nome = :nomeProgetto 
                        GROUP BY P.budget_avvio", [':nomeProgetto' => $nomeProgetto])[0];