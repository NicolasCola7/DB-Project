<?php
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nomeProgetto'])){
    //con il metodo urldecode mi assicuro che il valore passato nell'URL sia sicuro (evita problemi con caratteri speciali)
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    $profili = $db->query("SELECT P.nome, P.numero_posizioni from Profilo P where P.nomeProgetto = :nomeProg and P.numero_posizioni > 0", [':nomeProg' => $nomeProgetto]);
    echo json_encode($profili);
}else{
    echo 'Errore: Nessun progetto specificato.';
}