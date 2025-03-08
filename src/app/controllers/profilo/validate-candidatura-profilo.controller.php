<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_POST['nomeProgetto']) && isset($_POST['nomeProfilo']) && isset($_POST['emailUtente']) && isset($_POST['scelta'])){
    // Definizione dei parametri per la procedura di autenticazione nel database
    $parametri = [
        'nomeProfiloI' => $_POST['nomeProfilo'],
        'nomeProgettoI' => $_POST['nomeProgetto'],
        'emailUtenteI' => $_POST['emailUtente'],
        'sceltaCreatoreI' => $_POST['scelta'],
        '@esito' => '@esito' // Variabile di output dalla stored procedure
    ];
    $esito = $db->procedure("checkCandidatura", $parametri);

    //se l'esito è negativo, mostro un errore nella vista
    if($esito === 0){
        $_SESSION["utente"]["errore_validazione"] = "Si è verificato un errore.";
        unset($_SESSION['utente']['esito_validazione']); 
    }else if ($esito === 1){
        $azione = '';
        if($_POST['scelta'] == 1){
            $azione = "approvazione";
        }else{
            $azione = "rigetto";
        }
        $_SESSION['utente']['esito_validazione'] = "Operazione di ".$azione." avvenuta con successo.";
        unset($_SESSION['utente']['errore_validazione']);
    }

    $nomeProgetto = urlencode($_POST['nomeProgetto']);
    $nomeProfilo = urlencode($_POST["nomeProfilo"]);
    header("location: /home/info-progetto/profilo/candidature?nomeProgetto=$nomeProgetto&nomeProfilo=$nomeProfilo");
    exit();
}else{
    echo 'Errore: Nessun progetto specificato.';
}