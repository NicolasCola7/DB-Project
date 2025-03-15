<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
$nomeProfilo = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

// controllo che progetto e profilo essistano
$progettoEsistente = $db->query(
    'SELECT nome FROM Progetto WHERE nome = :nomeProgetto',
    [':nomeProgetto' => $nomeProgetto]
);
$profiloEsistente = $db->query(
    'SELECT nome FROM Profilo WHERE nomeProgetto = :nomeProgetto AND nome = :nomeProfilo',
    [':nomeProgetto' => $nomeProgetto, ':nomeProfilo' => $nomeProfilo]
);

if(!$progettoEsistente || !$profiloEsistente) {
    abort();
}

$parametri = [
        'nomeProfiloI' => $nomeProfilo,
        'nomeProgettoI' => $nomeProgetto,
        'emailUtenteI' => $email,
        '@esito' => '@esito'
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

header("location: /home/progetti/".$nomeProgetto."/profili");
exit();
