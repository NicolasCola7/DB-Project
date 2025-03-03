<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nomeProgetto']) && isset($_GET['nomeProfilo'])){
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    $nomeProfilo = urldecode($_GET["nomeProfilo"]);

    //query che mi restituisce le principali caratteristiche di ogni candidatura
    $query = $db->query("SELECT U.nome, U.cognome, C.stato, C.accettata as risultato 
                         from Candidatura C join Utente U on C.emailUtente = U.email 
                         where C.nomeProfilo = :nomeProfilo and C.nomeProgetto = :nomeProgetto", 
                         [':nomeProfilo' => $nomeProfilo, ':nomeProgetto' => $nomeProgetto]);
    echo json_encode($query);
}else{
    echo 'Errore: Nessun progetto specificato.';
}