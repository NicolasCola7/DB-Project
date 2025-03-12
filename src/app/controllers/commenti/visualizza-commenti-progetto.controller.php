<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];
//cotrollo che nell'url sia presente come parametro il nome del progetto
if(isset($_GET['nomeProgetto'])){
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    //query che mi restituisce le principali caratteristiche di un commento
    $commenti = $db->query("SELECT U.nickname, C.id, C.data, C.testo as commento, R.contenuto as risposta from Commento C left join Risposta R on C.id = R.idCommento join Utente U on C.emailUtente = U.email 
                        where C.nomeProgetto = :nomeProgetto order by C.id desc", [':nomeProgetto' => $nomeProgetto]);
                        
    require view('/commenti/visualizza-commenti-progetto.view.php', [$nomeProgetto, $commenti]);
}

exit();