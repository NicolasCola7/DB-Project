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
    $sk_possedute = $db->query("SELECT Sk_l.nomeSkill, Sk_l.livello 
        from Skill_Possesso Sk_l join Skill S on Sk_l.nomeSkill = S.nome join Skill_Requisito Sk_r on S.nome = Sk_r.nomeSkill
        where Sk_r.nomeProfilo = :nomeProfilo and Sk_r.nomeProgetto = :nomeProgetto and Sk_l.emailUtente = :email
        order by Sk_l.nomeSkill", 
        [":nomeProfilo" => $nomeProfilo, ":nomeProgetto" => $nomeProgetto, ":email" => $emailCandidato]);
    //query che mi restituisce le skill (nome e livello) richieste dal profilo
    $sk_richieste = $db->query("SELECT Sk_r.nomeSkill, Sk_r.livello 
        from Skill_Possesso Sk_l join Skill S on Sk_l.nomeSkill = S.nome join Skill_Requisito Sk_r on S.nome = Sk_r.nomeSkill
        where Sk_r.nomeProfilo = :nomeProfilo and Sk_r.nomeProgetto = :nomeProgetto and Sk_l.emailUtente = :email
        order by Sk_l.nomeSkill", 
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
    echo json_encode([$info_candidato,$sk_possedute,$sk_richieste, $sk_posseduteExtra]);
}else{
    echo 'Errore: Nessun progetto specificato.';
}