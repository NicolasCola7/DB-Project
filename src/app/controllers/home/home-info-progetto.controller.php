<?php
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nome']))
{
    //con il metodo urldecode mi assicuro che il valore passato nell'URL sia sicuro (evita problemi con caratteri speciali)
    $nomeProgetto = urldecode($_GET['nome']);

    //query per ricevere tutte le informazioni sul progetto
    $progetto = $db->query("SELECT P.nome, P.data_inserimento, P.data_limite, P.descr, P.stato, P.budget_avvio, 
           P.tipoProgetto, P.emailCreatore, U.nome AS nomeC, U.cognome AS cognomeC, 
           COALESCE(SUM(F.importo), 0) AS sommaFinRicevuti FROM Progetto P JOIN Utente U ON P.emailCreatore = U.email LEFT JOIN Finanziamento F ON F.nomeProgetto = P.nome WHERE P.nome = :nome
           GROUP BY P.nome",[':nome' => $nomeProgetto]);
    
    //query per ricevere tutte le informazioni sui componenti
    $componenti = $db->query("SELECT C.nome, C.prezzo, C.descr, C.quantita FROM Componente C WHERE C.nomeProgetto = :nomeProg", [':nomeProg' => $nomeProgetto]);
    
    //query per ricevere tutte le immagini del progetto
    $immaginiProgetto = $db->query("SELECT F.descrizione, F.urlImmagine FROM Foto_Progetto F WHERE F.nomeProgetto = :nomeProg", [':nomeProg' => $nomeProgetto]);
   
    //query per ricevere tutte le immagini delle reward del progetto
    $rewardProgetto = $db->query("SELECT R.descr AS descrizione, R.urlFoto FROM Reward R WHERE R.nomeProgetto = :nomeProg", [':nomeProg' => $nomeProgetto]);
    echo json_encode([$progetto, $componenti, $immaginiProgetto, $rewardProgetto]);
}
else
{
    echo 'Errore: Nessun progetto specificato.';
}