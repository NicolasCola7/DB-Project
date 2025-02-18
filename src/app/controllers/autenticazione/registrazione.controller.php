<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$luogo_nascita = $_POST['luogo-nascita'];
$anno_nascita =  (int) $_POST['anno-nascita'];
$email = $_POST['email'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
//se il check-box non è stato selezionato causa un errore
$check_creatore = isset($_POST['check-creatore']) ? $_POST['check-creatore'] : null;

// Inizializza un array per raccogliere eventuali errori di validazione
$errori = [];

// Controllo validità del nome (lunghezza tra 1 e 100 caratteri)
if (!Validatore::isString($nome, 1, 100)) {
    $errori['nome'] = "Devi inserire un nome valido!"; 
}

// Controllo validità del cognome (lunghezza tra 1 e 100 caratteri)
if (!Validatore::isString($cognome, 1, 100)) {
    $errori['cognome'] = "Devi inserire un cognome valido!"; 
}

// Controllo validità del luogo di nascita (lunghezza tra 1 e 100 caratteri)
if (!Validatore::isString($luogo_nascita, 1, 100)) {
    $errori['luogo_nascita'] = "Devi inserire un luogo di nascita valido!"; 
}

// Controllo validità dell'anno di nascita (minimo 1900)
if (!Validatore::isNumber($anno_nascita, 1900)) {
    $errori["anno_nascita"] = "Devi inserire un anno di nascita valido!";
}

// Controllo validità dell'email
if (!Validatore::isEmail($email)) {
    $errori['email'] = "Devi inserire un indirizzo email valido!"; 
}

// Controllo validità del nickname (lunghezza tra 1 e 50 caratteri)
if (!Validatore::isString($nickname, 1, 50)) {
    $errori['nickname'] = "Devi inserire un nickname valido!";
}

// Controllo validità della password (lunghezza tra 8 e 50 caratteri)
if (!Validatore::isString($password, 8, 50)) {
    $errori["password"] = "La password deve essere almeno 8 caratteri e al massimo 50!";
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($errori)) {
    require view("/autenticazione/registrazione.view.php", [
        "errori" => $errori
    ]);
    exit();
}

// Definizione dei parametri per la procedura di autenticazione nel database
$parametri = [
    'email' => $email,
    'password' => $password,
    'nome' => $nome,
    'cognome' => $cognome,
    'luogo_nascita' => $luogo_nascita,
    'anno_nascita' => $anno_nascita,
    'nickname' => $nickname,
    '@esito' => '@esito' // Variabile di output dalla stored procedure
];

if (isset($check_creatore)) 
{
    // Esegue la stored procedure "RegistrazioneCreatore" nel database
    $esito = $db->procedure("RegistrazioneCreatore", $parametri);
} 
else 
{
    // Esegue la stored procedure "RegistrazioneNormale" nel database
    $esito = $db->procedure("RegistrazioneNormale", $parametri);
}

// Se l'esito è negativo, mostra un errore nella vista login
if (!$esito) {
    $errori['procedura'] =  "Registrazione fallita!";
    require view("/autenticazione/registrazione.view.php", [
        'errori' => $errori
    ]);
    exit();
}

// Passiamo un messaggio di successo alla vista che terminerà con il click dell'utente
$messaggio_successo = "Registrazione completata con successo!";
require view("/autenticazione/registrazione.view.php", [ 
    "messaggio_successo" => $messaggio_successo 
]);
// Termina lo script
exit();