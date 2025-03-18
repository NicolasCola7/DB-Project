<?php
use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);
// ottendo id commento
$idCommento = urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]);

// controllo che progetto e commento esistano
$progettoEsistente = $db->query(
    "SELECT nome FROM Progetto WHERE nome = :nome",
    [':nome' => $nomeProgetto]
);
$commentoEsistente = $db->query(
    "SELECT id FROM Commento WHERE id = :id AND nomeProgetto = :nome",
    [':id' => $idCommento, ':nome' => $nomeProgetto]
);

if(!$progettoEsistente || !$commentoEsistente) {
    abort();
}

// Definizione dei parametri per la procedura di autenticazione nel MySqlDatabase
$parametri = [
    'idCommentoI' => $idCommento,
    'contenutoI' => $_POST['contenuto'],
    'emailCreatoreI' => $_SESSION['utente']['email'],
    '@esito' => '@esito' 
];

$esito = $db->procedure("rispondiACommento", $parametri);

//se l'esito è negativo, mostro un errore nella vista
if($esito === 0){
    $_SESSION["utente"]["errore_risposta"] = "L'operazione di invio della risposta non è andata a buon fine.";
    unset($_SESSION['utente']['esito_risposta']); 
} else if ($esito === 1) {
    $_SESSION['utente']['esito_risposta'] = "L'operazione di invio della risposta è andata a buon fine.";
    unset($_SESSION['utente']['errore_risposta']);
}

header("location: /home/i-miei-progetti/".$nomeProgetto."/commenti");
exit();
