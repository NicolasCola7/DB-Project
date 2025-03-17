<?php

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

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
    require view("/i-miei-progetti/inserimento-reward.view.php", [
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
        require view("/i-miei-progetti/inserimento-reward.view.php", [
            'errori' => $errori
    ]);
    exit();
}
//inserisco la foro nella dir apposita
move_uploaded_file($nomeTemp, $destinazione);

header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto));
exit();