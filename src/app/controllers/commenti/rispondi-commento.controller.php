<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];



//cotrollo che nell'url sia presente come parametro il nome del progetto
if(isset($_GET['nomeProgetto']) && isset($_GET['idCommento'])){
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    $id = urldecode($_GET['idCommento']);
    //query che mi restituisce le principali caratteristiche di un commento
    $commento = $db->query("SELECT U.nickname, C.id, C.data, C.testo as commento, R.contenuto as risposta from Commento C left join Risposta R on C.id = R.idCommento join Utente U on C.emailUtente = U.email 
    where C.nomeProgetto = :nomeProgetto and C.id = :id", [':nomeProgetto' => $nomeProgetto, ':id' => $id])[0];
    require view('/commenti/rispondi-commento.view.php', [$commento, $nomeProgetto]);
}
exit();