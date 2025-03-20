<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\Validatore;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista e sia software
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome AND tipoProgetto = 'Software' AND emailCreatore = :email",
     [':nome' => $nomeProgetto, ':email' => $email]
);

if(!$progettoEsistente) {
    abort();
}

//recupero dati del profilo
$skills = $_POST['skills'];
$skillsRichieste = [];
foreach($skills as $skill){
    array_push($skillsRichieste,['nomeSkill' => $skill['nome'], 'livello' => $skill['livello']]);
}
$nomeProfilo = $_POST['nome'];
$posizioniDisponibili = $_POST['posizioni'];

$errori = [];

if (!Validatore::isString($nomeProfilo, 1, 50)) {
    $errori["nome"] = "Nome del profilo non valido!";
}

if (!Validatore::isNumber($posizioniDisponibili, 1)) {
    $errori["posizioni"] = "Devi inserire almeno 1 posizione disponibile!";
}

//recupero le skills disponibili da ripassare alla view in caso di errori
$skills = $db->query('SELECT nome FROM Skill');

if (!empty($errori)) {
    require view("/i-miei-progetti/inserimento-profilo.view.php", [
        "errori" => $errori,
        "skills" => $skills
    ]);
    exit();
}


$paramsProfilo = [
    'nome' => $nomeProfilo,
    'nomeProgetto' => $nomeProgetto,
    'posizioni_disponibili' => $posizioniDisponibili,
    'skillrichieste' => json_encode($skillsRichieste),
    '@esito' => '@esito'
];

// inserisco profilo
$esito = $db->procedure('InserimentoProfilo', $paramsProfilo);

if (!$esito) {
    $errori['procedura'] =  "Si è verificato un errore imprevisto nell'inserimento del profilo!";
    require view("/i-miei-progetti/inserimento-profilo.view.php", [
        'errori' => $errori,
        'skills' => $skills
    ]);
    exit();
}

$db_mongo->inserisciLog("Nuovo profilo ".$nomeProfilo." inserito per il progetto ".$nomeProgetto);

header('location: /home/i-miei-progetti/'.urlencode($nomeProgetto).'/profili');
exit();
