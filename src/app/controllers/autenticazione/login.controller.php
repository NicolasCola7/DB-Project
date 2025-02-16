<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_POST['email'];
$password = $_POST['password'];

// Inizializza un array per raccogliere eventuali errori di validazione
$errori = [];

// Controllo validità dell'email
if (!Validatore::isEmail($email)) {
    $errori['email'] = "Devi inserire un indirizzo email valido!"; 

}

// Controllo validità della password (lunghezza tra 8 e 50 caratteri)
if (!Validatore::isString($password, 8, 50)) {
    $errori["password"] = "La password deve essere almeno 8 caratteri e al massimo 50!";
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($errori)) {
    return view("/autenticazione/login.view.php", [
        "errori" => $errori
    ]);
}

// Definizione dei parametri per la procedura di autenticazione nel database
$parametri = [
    'email' => $email,
    'password' => $password,
    '@esito' => '@esito' // Variabile di output dalla stored procedure
];

// Esegue la stored procedure "AutenticazioneNormale" nel database
$risultato = $db->procedure("AutenticazioneNormale", $parametri);

// Se l'esito è negativo, mostra un errore nella vista login
if (!$risultato['esito']) {
    return view("/autenticazione/login.view.php", [
        "errore" => "Email o password errata!"
    ]);
}

// Avvia la sessione per memorizzare i dati dell'utente autenticato
$_SESSION['utente'] = [
    'email' => $risultato['email']
];

// Reindirizza l'utente alla home dopo un login riuscito
header('location: /home');
exit(); // Termina lo script dopo il reindirizzamento
