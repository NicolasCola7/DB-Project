<?php

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;
use \core\MongoDatabase;
use \core\AlertManager;

// Ottiene un'istanza della classe MySqlDatabase dal container dell'applicazione
$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

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

// Controllo validità del nome (lunghezza tra 1 e 100 caratteri)
if (!Validatore::isString($nome, 1, 100)) {
    AlertManager::setError('nome', "Devi inserire un nome valido!"); 
}

// Controllo validità del cognome (lunghezza tra 1 e 100 caratteri)
if (!Validatore::isString($cognome, 1, 100)) {
    AlertManager::setError('cognome', "Devi inserire un cognome valido!"); 
}

// Controllo validità del luogo di nascita (lunghezza tra 1 e 100 caratteri)
if (!Validatore::isString($luogo_nascita, 1, 100)) {
    AlertManager::setError('luogo_nascita', "Devi inserire un luogo di nascita valido!"); 
}

// Controllo validità dell'anno di nascita (minimo 1900, massimo utnete maggiorennte)
$anno_corrente = date('Y');
$anno_massimo = $anno_corrente - 18;
if (!Validatore::isNumber($anno_nascita, 1920, $anno_massimo)) {
    AlertManager::setError("anno_nascita", "Il tuo anno di nascita deve essere compreso tra 1920 e ".$anno_massimo);
}

// Controllo validità dell'email
if (!Validatore::isEmail($email)) {
    AlertManager::setError('email', "Devi inserire un indirizzo email valido!"); 
}

// Controllo validità del nickname (lunghezza tra 1 e 50 caratteri)
if (!Validatore::isString($nickname, 1, 50)) {
    AlertManager::setError('nickname', "Devi inserire un nickname valido!");
}

// Controllo validità della password (lunghezza tra 8 e 50 caratteri)
if (!Validatore::isString($password, 8, 50)) {
    AlertManager::setError("password", "La password deve essere almeno 8 caratteri e al massimo 50!");
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($_SESSION['errore'])) {
    header('location: /registrazione');
    exit();
}

// Definizione dei parametri per la procedura di autenticazione nel MySqlDatabase
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

if (isset($check_creatore)) {
    // Esegue la stored procedure "RegistrazioneCreatore" nel MySqlDatabase
    $esito = $db->procedure("RegistrazioneCreatore", $parametri);
} else {
    // Esegue la stored procedure "RegistrazioneNormale" nel MySqlDatabase
    $esito = $db->procedure("RegistrazioneNormale", $parametri);
}

// Se l'esito è negativo, mostra un errore nella vista login
if (!$esito) {
    AlertManager::setError('procedura', "Registrazione fallita!");
    header('location: /registrazione');
    exit();
}

if($check_creatore) {
    $db_mongo->inserisciLog("Nuovo creatore registrato: email:".$email);
} else {
    $db_mongo->inserisciLog("Nuovo utente registrato: email:".$email);
}

AlertManager::setSuccess("Registrazione avvenuta correttamente, ora puoi accedere");
// reindirizzo l'utente al login
header('location: /login');
exit();