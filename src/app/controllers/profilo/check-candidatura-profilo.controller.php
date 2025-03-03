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

    //query che mi restituisce le principali caratteristiche di ogni candidatura
    $query = $db->query("", 
                         []);
    echo json_encode($query);
}else{
    echo 'Errore: Nessun progetto specificato.';
}