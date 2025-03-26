<?php
use \core\AlertManager;

$cartellaUtente = md5($_SESSION['utente']['nickname']);
$directoryTemporanea = 'public/immagini/temporanee/'.$cartellaUtente;

$rimossa = rimuoviDirectory($directoryTemporanea);
if(!$rimossa) {
    AlertManager::setError('eliminazione', "Si è verificato un errore nell'eliminazione");
    header('location: /home/crea-progetto/conferma-dati');
    exit();
}

//eliminiamo tutte le variabili per la creazione del progetto
unset($_SESSION['creazione-progetto']);
unset($_SESSION['aggiunta-foto']);
unset($_SESSION['aggiunta-reward']);
unset($_SESSION['aggiunta-skill']);
unset($_SESSION['aggiunta-componente']);

header('location: /home/crea-progetto/informazioni-base');
exit();