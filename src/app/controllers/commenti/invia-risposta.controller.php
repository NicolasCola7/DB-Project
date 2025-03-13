<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_POST['idCommento']) && isset($_POST['contenuto']) && isset($_POST['emailCreatore'])){
    // Definizione dei parametri per la procedura di autenticazione nel database
    $parametri = [
        'idCommentoI' => $_POST['idCommento'],
        'contenutoI' => $_POST['contenuto'],
        'emailCreatoreI' => $_POST['emailCreatore'],
        '@esito' => '@esito' // Variabile di output dalla stored procedure
    ];
    $esito = $db->procedure("rispondiACommento", $parametri);

    //se l'esito è negativo, mostro un errore nella vista
    if($esito === 0){
        $_SESSION["utente"]["errore_risposta"] = "L'operazione di invio della risposta non è andata a buon fine.";
        unset($_SESSION['utente']['esito_risposta']); 
    }else if ($esito === 1){
        $_SESSION['utente']['esito_risposta'] = "L'operazione di invio della risposta è andata a buon fine.";
        unset($_SESSION['utente']['errore_risposta']);
    }
    $nomeProgetto = urldecode($_GET['nomeProgetto']);
    header("location: /home/info-progetto/commenti?nomeProgetto=$nomeProgetto");
    exit();
}else{
    echo 'Errore: Nessun progetto specificato.';
}