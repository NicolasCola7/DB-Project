<?php

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;
use \core\AlertManager;

// Ottiene un'istanza della classe MySqlMySqlDatabase dal container dell'applicazione
$db = App::getContainer()->risolvi(MySqlDatabase::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_POST['email'];
$password = $_POST['password'];

// Controllo validità dell'email
if (!Validatore::isEmail($email)) {
    AlertManager::setError('email', "Devi inserire un indirizzo email valido!"); 
}

// Controllo validità della password (lunghezza tra 8 e 50 caratteri)
if (!Validatore::isPassword($password, 8, 50)) {
    AlertManager::setError("password", "La password deve essere almeno 8 caratteri e al massimo 50!");
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($_SESSION['errore'])) {
    header('location: /login');
    exit();
}

// Definizione dei parametri per la procedura di autenticazione nel MySqlDatabase
$parametri = [
    'email' => $email,
    'password' => $password,
    '@esito' => '@esito' // Variabile di output dalla stored procedure
];

// Esegue la stored procedure "AutenticazioneNormale" nel MySqlDatabase
$esito = $db->procedure("AutenticazioneNormale", $parametri);

// Se l'esito è negativo, mostra un errore nella vista login
if (!$esito) {
    AlertManager::setError('procedura', "Email o password errata!");
    header('location: /login');
    exit();
}

//Accedo al nickname dell'utente registrato
$risultatoQuery = $db->query("SELECT nickname FROM Utente WHERE email = :email", [':email' => $email]);

$checkCreatore = $db->query("SELECT emailCreatore FROM Creatore WHERE emailCreatore = :email", [':email' => $email]);

// Avvia la sessione per memorizzare i dati dell'utente autenticato
$_SESSION['utente'] = [
    'email' => $email,
    'nickname' => $risultatoQuery[0]['nickname'],
    'creatore' => (isset($checkCreatore[0]['emailCreatore']) ? true : false),
    'admin' => false
];

// Reindirizza l'utente alla home dopo un login riuscito
header('location: /home');
exit(); // Termina lo script dopo il reindirizzamento
