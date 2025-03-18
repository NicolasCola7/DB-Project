<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// a seconda della sezione in cui ci si trova controllo che il progettoo esista:
$progettoEsistente = [];
if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti') { // sezione progetti
    $progettoEsistente = $db->query(
        "SELECT nome FROM Progetto WHERE nome = :nomeProgetto",
        [':nomeProgetto' => $nomeProgetto]
    );
} else { // sezione i-miei-progetti
    $progettoEsistente = $db->query(
        "SELECT nome FROM Progetto WHERE nome = :nomeProgetto AND emailCreatore = :email",
        [':nomeProgetto' => $nomeProgetto, ':email' => $email]
    );
}

if(!$progettoEsistente) {
    abort();
}

$progetto = [];

$datiProgetto = $db->query(
    "SELECT 
    nome,
    tipoProgetto,
    data_limite,
    budget_avvio,
    data_inserimento,
    descr,
    stato
    FROM Progetto 
    WHERE nome = :nome", 
    [':nome' => $nomeProgetto]
);

$finanziamenti = $db->query(
    "SELECT SUM(importo) AS somma FROM Finanziamento WHERE nomeProgetto = :nome GROUP BY nomeProgetto",
     [':nome' => $nomeProgetto]
);

$progetto['rewards'] = $db->query(
    "SELECT urlFoto, descr FROM Reward WHERE nomeProgetto = :nomeProgetto",
    [':nomeProgetto' => $nomeProgetto]
);
$progetto['foto'] = $db->query(
    "SELECT urlImmagine, descrizione FROM Foto_Progetto WHERE nomeProgetto = :nomeProgetto",
    [':nomeProgetto' => $nomeProgetto]
);

$progetto['nome'] = $datiProgetto[0]['nome'];
$progetto['tipo'] = $datiProgetto[0]['tipoProgetto'];
$progetto['data_limite'] = $datiProgetto[0]['data_limite'];
$progetto['budget'] = $datiProgetto[0]['budget_avvio'];
$progetto['data_inserimento'] = $datiProgetto[0]['data_inserimento'];
$progetto['descrizione'] = $datiProgetto[0]['descr'];
$progetto['stato'] = $datiProgetto[0]['stato'];
$progetto['finanziamenti'] = isset($finanziamenti[0]['somma']) ? $finanziamenti[0]['somma']: '0.00';

if($progetto['tipo'] === 'Hardware') {
    $componenti = $db->query("SELECT nome, prezzo, descr, quantita FROM Componente WHERE nomeProgetto = :nome", [':nome' => $nomeProgetto]);
    $progetto['componenti'] = [];

    foreach($componenti as $componente) {
        array_push($progetto['componenti'], $componente);
    }
}

require view(
    '/progetti/info-progetto.view.php',
    ['progetto' => $progetto]
);

exit();