<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista e sia software
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome AND tipoProgetto = 'Software' ",
    [':nome' => $nomeProgetto]
);

if(!$progettoEsistente) {
    abort();
}

$skills = [];

$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

//controllo che il profilo esista
$profiloEsistente = $db->query(
    'SELECT nome FROM Profilo WHERE nome = :nomeProfilo AND nomeProgetto = :nomeProgetto',
     [':nomeProfilo' => $nomeProfilo, ':nomeProgetto' => $nomeProgetto]
);

if(!$profiloEsistente){
    abort();
}

$skills = $db->query(
    "SELECT nomeSkill, livello FROM Skill_Requisito WHERE nomeProgetto = :nomeProgetto AND nomeProfilo = :nomeProfilo",
     [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);

require view('/profilo/skills-profilo.view.php', ['skills' => $skills]);
exit();