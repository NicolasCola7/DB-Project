<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista e sia software
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome AND emailCreatore = :email AND tipoProgetto = 'Software' ", [':nome' => $nomeProgetto, ':email' => $email]);

if(!$progettoEsistente) {
    abort();
}

$profili = [];

$query = $db->query("SELECT nome, numero_posizioni FROM Profilo WHERE nomeProgetto = :nome", [':nome' => $nomeProgetto]);
foreach($query as $profilo) {
    array_push($profili, $profilo);
}

require view('/i-miei-progetti/vedi-profili.view.php', $profili);
exit();