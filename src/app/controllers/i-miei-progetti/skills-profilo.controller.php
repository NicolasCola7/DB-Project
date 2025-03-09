<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista e sia software
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome AND emailCreatore = :email AND tipoProgetto = 'Software' ", [':nome' => $nomeProgetto, ':email' => $email]);

if(!$progettoEsistente) {
    abort();
}

$skills = [];

$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

$query = $db->query("SELECT nomeSkill, livello FROM Skill_Requisito WHERE nomeProgetto = :nomeProgetto AND nomeProfilo = :nomeProfilo", [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]);
foreach($query as $skill) {
    array_push($skills, $skill);
}

require view('/i-miei-progetti/skills-profilo.view.php', $skills);
exit();