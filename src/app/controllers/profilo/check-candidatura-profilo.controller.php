<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nomeProgetto']) && isset($_GET['nomeProfilo']) && isset($_GET['email'])){
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    $nomeProfilo = urldecode($_GET["nomeProfilo"]);
    $emailCandidato = urldecode($_GET["email"]);

    //query che mi restituisce dai sul candidato
    $info_candidato = $db->query("SELECT email, nome, cognome, luogo_nascita, anno_nascita from Utente where email = :email", [":email"=>$emailCandidato]);
    //query che mi restituisce le skill (nome e livello) possedute dall'utente per quello specifico profilo
    $sk_possedute = $db->query("SELECT S.nome AS nomeSkill, COALESCE(Sk_l.livello, 0) AS livello
                                FROM Skill_Requisito Sk_r
                                JOIN Skill S ON Sk_r.nomeSkill = S.nome
                                LEFT JOIN Skill_Possesso Sk_l ON Sk_l.nomeSkill = S.nome AND Sk_l.emailUtente = :email
                                WHERE Sk_r.nomeProfilo = :nomeProfilo AND Sk_r.nomeProgetto = :nomeProgetto
                                ORDER BY S.nome", 
        [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]);
    //query che mi restituisce le skill (nome e livello) richieste dal profilo
    $sk_richieste = $db->query("SELECT S.nome AS nomeSkill, COALESCE(Sk_r.livello, 0) AS livello
                                FROM Skill_Requisito Sk_r
                                JOIN Skill S ON Sk_r.nomeSkill = S.nome
                                LEFT JOIN Skill_Possesso Sk_l ON Sk_l.nomeSkill = S.nome AND Sk_l.emailUtente = :email
                                WHERE Sk_r.nomeProfilo = :nomeProfilo AND Sk_r.nomeProgetto = :nomeProgetto
                                ORDER BY S.nome", 
        [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]);
    //query che restituisce le altre skill dell'utente che non sono richieste dal profilo
    $sk_posseduteExtra = $db->query("SELECT Sk_l.nomeSkill, Sk_l.livello
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
        [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]);
    //query che mi restituisce true se non esiste alcuna candidatura aperta di un certo utente, per un certo profilo e per un certo progetto
    $candidaturaGiaPresente = $db->query("SELECT NOT EXISTS (
                                        SELECT 1 
                                        FROM Candidatura C
                                        WHERE C.stato = 'aperta' 
                                        AND C.emailUtente = :email
                                        AND C.nomeProfilo = :nomeProfilo
                                        AND C.nomeProgetto = :nomeProgetto
                                    ) AS risultato",
        [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]);
    //query che mi restituisce true o false a seconda del fatto se l'utente possiede tutte le skill con livello adeguato al profilo
    $idoneita = $db->query("SELECT CASE 
                            WHEN COUNT(*) = 0 THEN 'TRUE' ELSE 'FALSE' END AS isQualified
                            FROM Skill_Requisito Sk_r
                            JOIN Skill S ON Sk_r.nomeSkill = S.nome
                            LEFT JOIN Skill_Possesso Sk_l ON Sk_l.nomeSkill = S.nome AND Sk_l.emailUtente = :email
                            WHERE Sk_r.nomeProfilo = :nomeProfilo AND Sk_r.nomeProgetto = :nomeProgetto AND (Sk_l.livello IS NULL OR Sk_l.livello < Sk_r.livello)",
                            [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]);
    echo json_encode([$info_candidato,$sk_possedute,$sk_richieste, $sk_posseduteExtra, $candidaturaGiaPresente, $idoneita]);
}else{
    echo 'Errore: Nessun progetto specificato.';
}