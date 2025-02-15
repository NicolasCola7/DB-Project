<?php

view("/autenticazione/login.view.php");

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errori = [];

if (!Validatore::isEmail($email)) {
    $errori['email'] = "Devi inserire un'indirizzo email valido!";
}

if(!Validatore::isString($password, 8, 50)) {
     $errori["password"] = "La password deve essere almeno 8 caratteri e al massimo 50 !";
}

if(!empty($errori)) {
    return view("/autenticazione/login.view.php",[
        "errori" => $errori
    ]);
}

$parametri = [
    'email' => $email,
    'password' => $password,
    '@esito' => '@esito'
];

$esito = $db->procedure("AutenticazioneNormale", $parametri);

if(!$esito)
    return view("/autenticazione/login.view.php",[
        "errore" => "Email o password errata !"
    ]);

header('location: /home');
exit();