<?php
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nome'])){
    //con il metodo urldecode mi assicuro che il valore passato nell'URL sia sicuro (evita problemi con caratteri speciali)
    $nomeProgetto = urldecode($_GET['nome']);
    $progetto = $db->query("SELECT P.nome, P.data_inserimento, P.data_limite, P.descr, P.stato, P.budget_avvio, 
           P.tipoProgetto, P.emailCreatore, U.nome AS nomeC, U.cognome AS cognomeC, 
           COALESCE(SUM(F.importo), 0) AS sommaFinRicevuti FROM Progetto P JOIN Utente U ON P.emailCreatore = U.email LEFT JOIN Finanziamento F ON F.nomeProgetto = P.nome WHERE P.nome = :nome
           GROUP BY P.nome",[':nome' => $nomeProgetto]);
    $componenti = $db->query("SELECT C.nome, C.prezzo, C.descr, C.quantita from Componente C where C.nomeProgetto = :nomeProg", [':nomeProg' => $nomeProgetto]);

    echo json_encode([$progetto,$componenti]);
}else{
    echo 'Errore: Nessun progetto specificato.';
}