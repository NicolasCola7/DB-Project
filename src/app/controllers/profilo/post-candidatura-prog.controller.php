<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_POST['nomeProgetto']) && isset($_POST['nomeProfilo'])){
    //con il metodo urldecode mi assicuro che il valore passato nell'URL sia sicuro (evita problemi con caratteri speciali)
    $nomeProgetto = $_POST['nomeProgetto'];
    $nomeProfilo = $_POST['nomeProfilo'];
    echo 'sono qui';
}else{
    echo 'Errore: Nessun progetto specificato.';
}