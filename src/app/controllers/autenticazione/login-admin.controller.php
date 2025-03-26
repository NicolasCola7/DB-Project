<?php

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;
use \core\AlertManager;

// Ottiene un'istanza della classe MySqlDatabase dal container dell'applicazione
$db = App::getContainer()->risolvi(MySqlDatabase::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_POST['email'];
$password = $_POST['password'];
$codiceSicurezza = (int) $_POST['codiceSicurezza'];

// Controllo validità dell'email
if (!Validatore::isEmail($email)) {
    AlertManager::setError('email', "Devi inserire un indirizzo email valido!"); 
}

// Controllo validità della password (lunghezza tra 8 e 50 caratteri)
if (!Validatore::isString($password, 8, 50)) {
    AlertManager::setError("password", "La password deve essere almeno 8 caratteri e al massimo 50!");
}

// Controllo validità del codice di sicurezza 
if (!Validatore::isNumber($codiceSicurezza, 1000, 9999)) {
    AlertManager::setError("codiceSicurezza", "Il codice di sicurezza deve essere numerico e deve essere di 4 cifre!");
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($_SESSION['errore'])) {
    header('location: /admin/login');
    exit();
}

// Definizione dei parametri per la procedura di autenticazione nel MySqlDatabase
$parametri = [
    'email' => $email,
    'password' => $password,
    'codiceSicurezza' => $codiceSicurezza,
    '@esito' => '@esito' // Variabile di output dalla stored procedure
];

// Esegue la stored procedure "AutenticazioneAmministratore" nel MySqlDatabase
$esito = $db->procedure("AutenticazioneAmministratore", $parametri);

// Se l'esito è negativo, mostra un errore nella vista login
if (!$esito) {
    AlertManager::setError("procedura", "Email, password o codice sicurezza errato!");
    header('location: /admin/login');
    exit();
}

//Accedo al nickname dell'utente registrato
$risultatoQuery = $db->query("SELECT nickname FROM Utente WHERE email = :email", [':email' => $email]);

// Avvia la sessione per memorizzare i dati dell'utente autenticato

$_SESSION['utente'] = [
    'email' => $email,
    'nickname' => $risultatoQuery[0]['nickname'],
    'admin' => true,
    'creatore' => false
];

// Reindirizza l'utente alla home dopo un login riuscito
header('location: /home');
exit(); // Termina lo script dopo il reindirizzamento