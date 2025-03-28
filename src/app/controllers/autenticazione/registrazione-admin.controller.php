<?php

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;
use \core\MongoDatabase;
use \core\AlertManager;

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
$conferma_password = $_POST['conferma-password'];
$codiceSicurezza = (int) $_POST['codiceSicurezza'];


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
if (!Validatore::isPassword($password, 8, 50)) {
    AlertManager::setError("password", "La password deve essere almeno 8 caratteri e al massimo 50!");
}

// Controllo uguaglianza delle due password inserite
if($password != $conferma_password) {
    AlertManager::setError("password_errate", "La due password non coincidono!");
}

// Controllo validità del codice di sicurezza
if (!Validatore::isNumber($codiceSicurezza, 1000, 9999)) {
    AlertManager::setError("codice", "Devi inserire un codice di 4 cifre!");
}

// Se ci sono errori di validazione, torna alla vista del login con i messaggi di errore
if (!empty($_SESSION['errore'])) {
    header('location: /admin/registrazione');
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
    'codice' => $codiceSicurezza,
    '@esito' => '@esito' // Variabile di output dalla stored procedure
];


// Esegue la stored procedure "RegistrazioneAmministratore" nel MySqlDatabase
$esito = $db->procedure("RegistrazioneAmministratore", $parametri);

// Se l'esito è negativo, mostra un errore nella vista login
if (!$esito) {
    AlertManager::setError('procedura', "Email, password, codice errati o email/nickname già esistente!");
    header('location: /admin/registrazione');
    exit();
}

AlertManager::setSuccess("Registrazione avvenuta correttamente, ora puoi accedere");
$db_mongo->inserisciLog("Nuovo admin registrato: email:".$email);
header('location: /admin/login');
exit();