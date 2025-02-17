<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// TEO -> DA FINIRE!!!!!!!
// controllare la validità dei campi 
// aggiungere tipologia errore html

// Recupera i dati inviati dal form tramite il metodo POST
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$luogo_nascita = $_POST['luogo-nascita'];
$anno_nascita = $_POST['anno-nascita'];
$email = $_POST['email'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$conferma_password = $_POST['conferma-password'];
$check_creator = $_POST['check-creator'];

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

if (isset($check_creator)) 
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

// Reindirizza l'utente al login dopo la registrazione riuscita
header('location: /login');
// Termina lo script dopo il reindirizzamento
exit();