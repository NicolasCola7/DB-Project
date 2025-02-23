<?php
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_GET['nome'])){
    //con il metodo urldecode mi assicuro che il valore passato nell'URL sia sicuro (evita problemi con caratteri speciali)
    $nomeProgetto = urldecode($_GET['nome']);
    $progetto = $db->query("select P.nome, P.data_inserimento, P.data_limite, P.descr, P.stato, P.budget_avvio, P.tipoProgetto, P.emailCreatore, U.nome as nomeC, U.cognome as cognomeC
    from Progetto P join Utente U on P.emailCreatore = U.email where P.nome = :nome",[':nome' => $nomeProgetto]);
    
    echo json_encode($progetto);
}else{
    echo 'Errore: Nessun progetto specificato.';
}