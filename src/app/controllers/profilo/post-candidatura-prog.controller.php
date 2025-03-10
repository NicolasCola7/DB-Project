<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_POST['nomeProgetto']) && isset($_POST['nomeProfilo'])){
    // Definizione dei parametri per la procedura di autenticazione nel database
    $parametri = [
        'nomeProfiloI' => $_POST['nomeProfilo'],
        'nomeProgettoI' => $_POST['nomeProgetto'],
        'emailUtenteI' => $_SESSION['utente']['email'],
        '@esito' => '@esito' // Variabile di output dalla stored procedure
    ];
    $esito = $db->procedure("InserimentoCandidatura", $parametri);
    
    //se l'esito è negativo, mostro un errore nella vista
    if($esito === 0){
        $_SESSION["utente"]["errore_candidatura"] = "Non disponi di tutti i livelli skill minimi richiesti dal profilo.";
        unset($_SESSION['utente']['esito_candidatura']); 
    }else if ($esito === 1){
        $_SESSION['utente']['esito_candidatura'] = "Candidatura inviata con successo!";
        unset($_SESSION['utente']['errore_candidatura']);
    }else if ($esito === 2){
        $_SESSION["utente"]["errore_candidatura"] = "Hai già inviato una candidatura per questo profilo che non è stata ancora visionata.";
        unset($_SESSION['utente']['esito_candidatura']); 
    }else {
        $_SESSION["utente"]["errore_candidatura"] = "Hai già inviato una candidatura per questo profilo che è già stata accettata.";
        unset($_SESSION['utente']['esito_candidatura']); 
    }

    $nomeProgetto = urlencode($_POST['nomeProgetto']);
    header("location: /home/info-progetto/profili?nomeProgetto=$nomeProgetto");
    exit();
}else{
    echo 'Errore: Nessun progetto specificato.';
}