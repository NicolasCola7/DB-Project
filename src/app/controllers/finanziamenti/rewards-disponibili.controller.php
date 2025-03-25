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
$percFinanziamento = $_GET['perc_finanziamenti'];

$valori = $db->query("SELECT P.budget_avvio, sum(F.importo) as sommaRicevuta 
                      from Progetto P join Finanziamento F on P.nome = F.nomeProgetto 
                      where P.nome = :nomeProgetto
                      group by P.budget_avvio", [':nomeProgetto' => $nomeProgetto])[0];
require view('/finanziamenti/inserisci-finanziamento.view.php', ['rewards' => $rewards, 'percFinanziamento' => $percFinanziamento, 'valori' => $valori]);
exit();