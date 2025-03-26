<?php

use \core\Validatore;
use \core\AlertManager;

$file = $_FILES['foto'];
$nomeFile = $_FILES['foto']['name'];
$nomeTemp = $_FILES['foto']['tmp_name'];
$dimensione = $_FILES['foto']['size'];
$erroreFile = $_FILES['foto']['error'];
$tipoFile = $_FILES['foto']['type'];

$estensioneParts = explode('.', $nomeFile);
$estensione = strtolower(end($estensioneParts));

$descrizione = $_POST['descrizione'];


if (!Validatore::estensioneValida($estensione)) {
    AlertManager::setError("estensione", "Estensione non valida, deve essere del tipo .png, jpg, webp o avif!");
}

if (!Validatore::isNumber($dimensione, 1, 3145728)) {
    AlertManager::setError("dimensione", "La dimensione del file non deve superare i 3 MB");
}

if (!Validatore::isString($descrizione, 1, 100)) {
    AlertManager::setError("descrizione", "Descrizione non valida!");
}

if (!empty($_SESSION['errore'])) {
    header('location: /home/crea-progetto/rewards');
    exit();
}

/* genero una cartella univoca con il nome del nickname in mode che, quando vado a confrontare 
che non ci siano immagini uguali, non vada in conflitto con immagini inserite da altri utenti
*/
$cartellaUtente = md5($_SESSION['utente']['nickname']);
$directory = 'public/immagini/temporanee/'.$cartellaUtente.'/fotoRewards/';

if (!file_exists($directory)) {
   mkdir($directory, 0777, true);// 0750 è il codice per gestire accessi alla directory
}

$destinazione = $directory.$nomeFile;

$rewardDaInserire = [
    'urlFoto' => $destinazione,
    'descr' => $descrizione
];

//controllo che non esista una foto identica
foreach($_SESSION['creazione-progetto']['rewards'] as $reward) {
    if($reward['urlFoto'] === $destinazione) {
        AlertManager::setWarning("Reward già inserita!");
        header('location: /home/crea-progetto/rewards');
        exit();
    }
}

//inserisco la foto nella sessione
array_push($_SESSION['creazione-progetto']['rewards'], $rewardDaInserire);

// sposto la foto in una cartella temporanea in attesa per la conferma di creazione del progetto
move_uploaded_file($nomeTemp, $destinazione);
AlertManager::setSuccess("Reward aggiunta!");

header('location: /home/crea-progetto/rewards');
exit();