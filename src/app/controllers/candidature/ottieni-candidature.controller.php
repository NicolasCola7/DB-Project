<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

$candidature = $db->query(
    "SELECT C.nomeProgetto, C.nomeProfilo, C.stato, C.accettata, MIN(FP.urlImmagine) as logoProgetto 
     FROM Candidatura C join Foto_Progetto FP on C.nomeProgetto = FP.nomeProgetto
     where C.emailUtente = :emailUtente
     group by C.nomeProgetto, C.nomeProfilo, C.stato, C.accettata",
     [':emailUtente' => $email]
);

require view('/candidature/ottieni-candidature.view.php',['candidature' => $candidature]);
exit();