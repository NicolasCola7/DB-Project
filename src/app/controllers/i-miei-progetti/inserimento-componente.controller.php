<?php

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

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

$errori = [];

if (!Validatore::isString($nome, 1, 50)) {
    $errori["nome"] = "Nome del componente non valido";
}

if (!Validatore::isString($descrizione, 1, 100)) {
    $errori["descrizione"] = "Descrizione troppo lunga!";
}

if (!Validatore::isNumber($quantita, 1)) {
    $errori["quantita"] = "La quantità minima deve essere 1!";
}

if (!Validatore::isNumber($prezzo, 1)) {
    $errori["prezzo"] = "Il prezzo minimo deve essere 1!";
}

if (!empty($errori)) {
    require view("/i-miei-progetti/inserimento-componente.view.php", [
        "errori" => $errori
    ]);
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
    $errori['procedura'] =  "Si è verificato un errore imprevisto nell'inserimento della componente hardware!";
    require view("/i-miei-progetti/inserimento-componente.view.php", [
        'errori' => $errori
    ]);
    exit();
}

header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto));
exit();