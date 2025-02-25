<?php
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nomeProgetto']) && isset($_GET['nomeProfilo'])){
    //con il metodo urldecode mi assicuro che il valore passato nell'URL sia sicuro (evita problemi con caratteri speciali)
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    $nomeProfilo = urldecode($_GET['nomeProfilo']);
    $query = $db->query("SELECT S.nomeSkill, S.livello from Skill_Requisito S where S.nomeProfilo = :nomeProfilo and S.nomeProgetto = :nomeProgetto ",[':nomeProfilo' => $nomeProfilo,':nomeProgetto' => $nomeProgetto]);
    echo json_encode($query);
}else{
    echo 'Errore: Nessun progetto specificato.';
}