<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$emailCreatore = $_SESSION['utente']['email'];
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);
$idCandidatura = urldecode(explode('/', $_SERVER['REQUEST_URI'])[7]);

// controllo che progetto, profilo  e candidatura esistano
$progettoEsistente = $db->query(
    'SELECT nome FROM Progetto WHERE nome = :nomeProgetto AND emailCreatore = :emailCreatore',
    [':nomeProgetto' => $nomeProgetto, ':emailCreatore' => $emailCreatore]
);
$profiloEsistente = $db->query(
    'SELECT nome FROM Profilo WHERE nomeProgetto = :nomeProgetto AND nome = :nomeProfilo',
    [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);
$candidaturaEsistente = $db->query(
    "SELECT id FROM Candidatura WHERE id = :id AND nomeProgetto = :nomeProgetto AND nomeProfilo = :nomeProfilo",
    [':id' => $idCandidatura, ':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);

if(!$progettoEsistente || !$profiloEsistente || !$candidaturaEsistente) {
    abort();
}

//ottengo la mail dell'utente candidato
$emailCandidato = $db->query(
    "SELECT emailUtente FROM Candidatura WHERE id = :id",
    [':id' => $idCandidatura]
)[0]['emailUtente'];


//query che mi restituisce dati sul candidato
$candidato = $db->query(
    "SELECT email, nome, cognome, luogo_nascita, anno_nascita from Utente where email = :email",
     [":email" => $emailCandidato]
);

//query che mi restituisce le skill (nome e livello) possedute dall'utente per quello specifico profilo
$possedute = $db->query(
    "SELECT S.nome AS nomeSkill, COALESCE(Sk_l.livello, 0) AS livello
     FROM Skill_Requisito Sk_r
     JOIN Skill S ON Sk_r.nomeSkill = S.nome
     LEFT JOIN Skill_Possesso Sk_l ON Sk_l.nomeSkill = S.nome AND Sk_l.emailUtente = :email
     WHERE Sk_r.nomeProfilo = :nomeProfilo AND Sk_r.nomeProgetto = :nomeProgetto
     ORDER BY S.nome", 
    [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]
);

//query che mi restituisce le skill (nome e livello) richieste dal profilo
$richieste = $db->query(
    "SELECT S.nome AS nomeSkill, COALESCE(Sk_r.livello, 0) AS livello
     FROM Skill_Requisito Sk_r
     JOIN Skill S ON Sk_r.nomeSkill = S.nome
     LEFT JOIN Skill_Possesso Sk_l ON Sk_l.nomeSkill = S.nome AND Sk_l.emailUtente = :email
     WHERE Sk_r.nomeProfilo = :nomeProfilo AND Sk_r.nomeProgetto = :nomeProgetto
     ORDER BY S.nome", 
    [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]
);

//query che restituisce le altre skill dell'utente che non sono richieste dal profilo
$posseduteExtra = $db->query(
    "SELECT Sk_l.nomeSkill, Sk_l.livello
     FROM Skill_Possesso Sk_l
     WHERE Sk_l.emailUtente = :email
     AND NOT EXISTS (
        SELECT 1 
        FROM Skill_Requisito Sk_r
        WHERE Sk_l.nomeSkill = Sk_r.nomeSkill 
        AND Sk_r.nomeProfilo = :nomeProfilo
        AND Sk_r.nomeProgetto = :nomeProgetto
    )
    ORDER BY Sk_l.nomeSkill;", 
    [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]
);

//query che mi restituisce true se non esiste alcuna candidatura aperta di un certo utente, per un certo profilo e per un certo progetto
$presente = $db->query(
    "SELECT NOT EXISTS (
        SELECT 1 
        FROM Candidatura C
        WHERE C.stato = 'aperta' 
        AND C.emailUtente = :email
        AND C.nomeProfilo = :nomeProfilo
        AND C.nomeProgetto = :nomeProgetto
        AND C.id = :idCandidatura
    ) AS risultato",
    [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato, ":idCandidatura" => $idCandidatura]
);
//query che mi restituisce true o false a seconda del fatto se l'utente possiede tutte le skill con livello adeguato al profilo
$idoneita = $db->query(
    "SELECT CASE 
        WHEN COUNT(*) = 0 THEN 
            'true'
        ELSE 
            'false' 
    END AS isQualified
    FROM Skill_Requisito Sk_r
    JOIN Skill S ON Sk_r.nomeSkill = S.nome
    LEFT JOIN Skill_Possesso Sk_l ON Sk_l.nomeSkill = S.nome AND Sk_l.emailUtente = :email
    WHERE Sk_r.nomeProfilo = :nomeProfilo AND Sk_r.nomeProgetto = :nomeProgetto AND (Sk_l.livello IS NULL OR Sk_l.livello < Sk_r.livello)",
    [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]
);

require view(
    '/profilo/vedi-candidatura.view.php',
    [
        'candidato' => $candidato,
        'possedute' => $possedute,
        'richieste' => $richieste,
        'posseduteExtra' => $posseduteExtra,
        'presente' => $presente,
        'idoneita' => $idoneita
    ]
);

exit();