<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];
//query che mi restituisce le principali caratteristiche di un commento
$commento = $db->query("SELECT U.nickname, C.id, C.data, C.testo as commento, R.contenuto as risposta from Commento C left join Risposta R on C.id = R.idCommento join Utente U on C.emailUtente = U.email 
                        where C.nomeProgetto = :nomeProgetto and C.id = '1'", [':nomeProgetto' => $nomeProgetto]);
require view('/commenti/rispondi-commento.view.php', $commento);

exit();