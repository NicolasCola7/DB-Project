<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

$finanziamenti = $db->query(
    "SELECT F.data, F.nomeProgetto, F.importo, R.descr AS descrizioneReward, FP.urlImmagine AS logoProgetto, R.urlFoto AS fotoReward
     FROM Finanziamento F JOIN Reward R ON R.codice = F.codiceReward JOIN (
        SELECT nomeProgetto, MIN(urlImmagine) AS urlImmagine 
        FROM Foto_Progetto 
        GROUP BY nomeProgetto
     ) FP ON F.nomeProgetto = FP.nomeProgetto
     WHERE F.emailUtente = :emailUtente",
     [':emailUtente' => $email]
);

$progettiFinanziati = $db->query(
   "SELECT DISTINCT(nomeProgetto) FROM Finanziamento WHERE emailUtente = :emailUtente",
   [':emailUtente' => $email]
);
require view('/finanziamenti/ottieni-finanziamenti.view.php', ['finanziamenti' => $finanziamenti, 'progettiFinanziati' => $progettiFinanziati]);
exit();