<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_POST['email'];
$password = $_POST['password'];
$codiceSicurezza = (int) $_POST['codiceSicurezza'];

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

// Controllo validità del codice di sicurezza (massimo 4 cifre, solo numeri)
if (!Validatore::isNumber($codiceSicurezza, 1, 9999)) {
    $errori["codiceSicurezza"] = "Il codice di sicurezza deve essere numerico e deve essere massimo 4 cifre!";
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($errori)) {
    require view("/autenticazione/login-admin.view.php", [
        "errori" => $errori
    ]);
    exit();
}

// Definizione dei parametri per la procedura di autenticazione nel database
$parametri = [
    'email' => $email,
    'password' => $password,
    'codiceSicurezza' => $codiceSicurezza,
    '@esito' => '@esito' // Variabile di output dalla stored procedure
];

// Esegue la stored procedure "AutenticazioneAmministratore" nel database
$esito = $db->procedure("AutenticazioneAmministratore", $parametri);

// Se l'esito è negativo, mostra un errore nella vista login
if (!$esito) {
    $errori['procedura'] =  "Email, password o codice sicurezza errato!";
    require view("/autenticazione/login-admin.view.php", [
        'errori' => $errori
    ]);
    exit();
}

//Accedo al nickname dell'utente registrato
$risultatoQuery = $db->query("SELECT nickname FROM Utente WHERE email = :email", [':email' => $email]);

// Avvia la sessione per memorizzare i dati dell'utente autenticato
$_SESSION['utente'] = [
    'email' => $email,
    'nickname' => $risultatoQuery[0]['nickname']
];

// Reindirizza l'utente alla home dopo un login riuscito
header('location: /home');
exit(); // Termina lo script dopo il reindirizzamento