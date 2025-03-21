<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\Validatore;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista e siahardware
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome AND emailCreatore = :email",
     [':nome' => $nomeProgetto, ':email' => $email]
);

if(!$progettoEsistente) {
    abort();
}

$file = $_FILES['foto'];
$nomeFile = $_FILES['foto']['name'];
$nomeTemp = $_FILES['foto']['tmp_name'];
$dimensione = $_FILES['foto']['size'];
$erroreFile = $_FILES['foto']['error'];
$tipoFile = $_FILES['foto']['type'];

$estensioneParts = explode('.', $nomeFile);
$estensione = strtolower(end($estensioneParts));

$descrizione = $_POST['descrizione'];

$errori = [];

if (!Validatore::estensioneValida($estensione)) {
    $errori["estensione"] = "Estensione non valida, deve essere del tipo .png, jpg o jpeg!";
}

if (!Validatore::isNumber($dimensione, 1, 3145728)) {
    $errori["dimensione"] = "La dimensione del file non deve superare i 3 MB";
}

if (!Validatore::isString($descrizione, 1, 100)) {
    $errori["descrizione"] = "Descrizione non valida!";
}

if (!empty($errori)) {
    require view("/creazione-progetto/inserimento-foto-o-rewards.view.php", [
        "errori" => $errori
    ]);

    exit();
}

$directoryFotoProgetto = 'public/immagini/progetti/'.urlencode($nomeProgetto).'/fotoReward';
$destinazione = $directoryFotoProgetto . '/' . $nomeFile;

$paramsReward = [
    'url' => $destinazione,
    'descrizione' => $descrizione,
    'nomeProgetto' => $nomeProgetto,
    '@esito' => '@esito'
];

$esito = $db->procedure('CreazioneReward', $paramsReward);

if(!$esito) {
    $errori['procedura'] =  "Si è verificato un errore imprevisto nell'inserimento delle foto del progetto!";
        require view("/creazione-progetto/inserimento-foto-o-rewards.view.php", [
            'errori' => $errori
    ]);
    exit();
}
//inserisco la foro nella dir apposita
move_uploaded_file($nomeTemp, $destinazione);

$db_mongo->inserisciLog("Nuova reward ".$nomeFile." inserita per il progetto ".$nomeProgetto);
header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto));
exit();