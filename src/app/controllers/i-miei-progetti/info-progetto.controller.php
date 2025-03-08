<?php
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);


// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

if(isset($nomeProgetto)){

    $progetto = $db->query("SELECT P.nome, P.data_inserimento, P.data_limite, P.descr, P.stato, P.budget_avvio, 
           P.tipoProgetto, P.emailCreatore, U.nome AS nomeC, U.cognome AS cognomeC, 
           COALESCE(SUM(F.importo), 0) AS sommaFinRicevuti FROM Progetto P JOIN Utente U ON P.emailCreatore = U.email LEFT JOIN Finanziamento F ON F.nomeProgetto = P.nome WHERE P.nome = :nome
           GROUP BY P.nome",[':nome' => $nomeProgetto]);
    $componenti = $db->query("SELECT C.nome, C.prezzo, C.descr, C.quantita from Componente C where C.nomeProgetto = :nomeProg", [':nomeProg' => $nomeProgetto]);

    echo json_encode([$progetto,$componenti]);
} else {
    echo 'Errore: Nessun progetto specificato.';
}

exit();