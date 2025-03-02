<?php
header('Content-Type: application/json'); 
use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);
//controllo se il parametro è stato passato nell'url di una chiamata get
if(isset($_POST['nomeProgetto']) && isset($_POST['nomeProfilo'])){
    //inizializzo un array per raccogliere eventuali errori
    $errori = [];

    // Definizione dei parametri per la procedura di autenticazione nel database
    $parametri = [
        'nomeProfiloI' => $_POST['nomeProgetto'],
        'nomeProgettoI' => $_POST['nomeProfilo'],
        'emailUtenteI' => $_SESSION['utente']['email'],
        '@esito' => '@esito' // Variabile di output dalla stored procedure
    ];

    $esito = $db->procedure("InserimentoCandidatura", $parametri);
    echo $esito;
    /*
    //se l'esito è negativo, mostro un errore nella vista
    if(!$esito){
        $errori["procedura"] = "Inserimento fallito. Non disponi di tutti i livelli skill minimi richiesti dal profilo.";
        require view("/profilo/view-profili.view.php", [
            'errori' => $errori
        ]);
        exit();
    }*/
    header("location: /home/info-progetto/profili");
    exit();
}else{
    echo 'Errore: Nessun progetto specificato.';
}