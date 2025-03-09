<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome AND emailCreatore = :email", [':nome' => $nomeProgetto, ':email' => $email]);

if(!$progettoEsistente) {
    abort();
}

$progetto = [];

$tipo = $db->query("SELECT tipoProgetto FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto])[0]['tipoProgetto'];
$data_limite = $db->query("SELECT data_limite FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto])[0]['data_limite'];
$budget = $db->query("SELECT budget_avvio FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto])[0]['budget_avvio'];
$data_inserimento = $db->query("SELECT data_inserimento FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto])[0]['data_inserimento'];
$descrizione = $db->query("SELECT descr FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto])[0]['descr'];
$stato = $db->query("SELECT stato FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto])[0]['stato'];
$finanziamenti = $db->query("SELECT SUM(importo) AS somma FROM Finanziamento WHERE nomeProgetto = :nome GROUP BY nomeProgetto", [':nome' => $nomeProgetto]);

$progetto['nome'] = $nomeProgetto;
$progetto['tipo'] = $tipo;
$progetto['data_limite'] = $data_limite;
$progetto['budget'] = $budget;
$progetto['data_inserimento'] = $data_inserimento;
$progetto['descrizione'] = $descrizione;
$progetto['stato'] = $stato;
$progetto['finanziamenti'] = isset($finanziamenti[0]['somma']) ? $finanziamenti[0]['somma']: '0.00';

if($tipo === 'Hardware') {
    $componenti = $db->query("SELECT nome, prezzo, descr, quantita FROM Componente WHERE nomeProgetto = :nome", [':nome' => $nomeProgetto]);
    $progetto['componenti'] = [];

    foreach($componenti as $componente) {
        array_push($progetto['componenti'], $componente);
    }
}

require view('/i-miei-progetti/info-progetto.view.php', $progetto);

exit();