<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$errori = [];

$email = $_SESSION['utente']['email'];
$nomeProgetto = $_SESSION['creazione-progetto']['nome'];
$dataLimite = $_SESSION['creazione-progetto']['data-limite'];
$budget = $_SESSION['creazione-progetto']['budget'];
$tipo = $_SESSION['creazione-progetto']['tipo'];
$descrizione = $_SESSION['creazione-progetto']['descrizione'];

$paramsProgetto = [
    'nome' => $nomeProgetto,
    'data_limite' => $dataLimite,
    'descrizione' => $descrizione,
    'budget' => $budget,
    'tipo' => $tipo,
    'emailCreatore' => $email,
    '@esito' => '@esito'
];

// inseriment o progetto
$esito = $db->procedure('CreazioneProgetto', $paramsProgetto);

if (!$esito) {
    AlertManager::setError('procedura', "Si è verificato un errore imprevisto nella creazione del progetto!");
    header('location: /home/crea-progetto/conferma-dati');
    exit();
}

//log creazione progetto
$db_mongo->inserisciLog("Nuovo progetto ".$nomeProgetto." creato da ".$email);

// inserimento componenti o profili
if($tipo === 'software') {
    foreach($_SESSION['creazione-progetto']['profili'] as $profilo) {
        $nomeProfilo = $profilo['nome'];
        $posizioniDisponibili = $profilo['numero_posizioni'];
        $skills = $profilo['skills-richieste'];

        $paramsProfilo = [
            'nome' => $nomeProfilo,
            'nomeProgetto' => $nomeProgetto,
            'posizioni_disponibili' => $posizioniDisponibili,
            'skillrichieste' => json_encode($skills),
            '@esito' => '@esito'
        ];

        // inserisco profilo
        $esito = $db->procedure('InserimentoProfilo', $paramsProfilo);

        if (!$esito) {
            AlertManager::setError('procedura', "Si è verificato un errore imprevisto nella creazione dei profili!");
            header('location: /home/crea-progetto/conferma-dati');
            exit();
        }

        //log inserimento profilo
        $db_mongo->inserisciLog("Nuovo profilo ".$nomeProfilo." inserito per il progetto ".$nomeProgetto);
    }
} else {
    foreach($_SESSION['creazione-progetto']['componenti'] as $componente) {
        $nomeComponente = $componente['nome'];
        $descrizioneComponente = $componente['descrizione'];
        $prezzoComponente = $componente['prezzo'];
        $quantitaComponente = $componente['quantita'];

        $paramsComponente = [
            'nomeComponente' => $nomeComponente,
            'nomeProgetto' => $nomeProgetto,
            'descrizione' => $descrizioneComponente,
            'prezzo' => $prezzoComponente,
            'quantita' => $quantitaComponente,
            '@esito' => '@esito'
        ];

        $esito = $db->procedure('InserimentoComponenteHardware', $paramsComponente);

        if (!$esito) {
            AlertManager::setError('procedura', "Si è verificato un errore imprevisto nella creazione delle componenti hardware!");
            header('location: /home/crea-progetto/conferma-dati');
            exit();
        }

        // log inserimento componente
        $db_mongo->inserisciLog("Nuova componente ".$nomeComponente." inserita per il progetto ".$nomeProgetto);
    }
}

//inserimento foto

// creo una nuova cartella definitiva per questo progetto ed elimino quella temporanea
$cartellaUtente = md5($_SESSION['utente']['nickname']);
$directoryFotoProgetto = 'public/immagini/progetti/'.urlencode($nomeProgetto).'/fotoProgetto';

if (!file_exists($directoryFotoProgetto)) {
    mkdir($directoryFotoProgetto, 0777, true);// 0750 è il codice per gestire accessi alla directory
}

foreach($_SESSION['creazione-progetto']['foto'] as $foto) {
    $urlTemporaneo = $foto['percorso'];
    $descrizioneFoto = $foto['descrizione'];

    $nomeFile = basename($urlTemporaneo);
    $destinazione = $directoryFotoProgetto . '/' . $nomeFile;
    
    copy($urlTemporaneo, $destinazione);
    unlink($urlTemporaneo);
    
    $nuovoUrl = $destinazione;

    $paramsFoto = [
        'url' => $nuovoUrl,
        'descrizione' => $descrizioneFoto,
        'nomeProgetto' => $nomeProgetto,
        '@esito' => '@esito'
    ];

    $esito = $db->procedure('InserimentoFotoProgetto', $paramsFoto);

    if(!$esito) {
        AlertManager::setError('procedura', "Si è verificato un errore imprevisto nell'inserimento delle foto del progetto!");
        header('location: home/crea-progetto/conferma-dati');
        exit();
    }

    //log foto
    $db_mongo->inserisciLog("Nuova foto ".$nomeFile." inserita per il progetto ".$nomeProgetto);
}


//inserimento rewards

/// creo directory definitiva per reward di questo progetto
$directoryFotoRewards = 'public/immagini/progetti/'.urlencode($nomeProgetto).'/fotoRewards';

if (!file_exists($directoryFotoRewards)) {
    mkdir($directoryFotoRewards, 0777, true);// 0750 è il codice per gestire accessi alla directory
}

foreach($_SESSION['creazione-progetto']['rewards'] as $reward) {
    $urlTemporaneo = $reward['urlFoto'];
    $descrizioneReward = $reward['descr'];

    //copio l'immagine nella nuova cartella e lo elimino dalla vecchia
    $nomeFile = basename($urlTemporaneo);
    $destinazione = $directoryFotoRewards . '/' . $nomeFile;
    
    copy($urlTemporaneo, $destinazione);
    unlink($urlTemporaneo);
    
    $nuovoUrl = $destinazione;

    $paramsReward = [
        'url' => $nuovoUrl,
        'descrizione' => $descrizioneFoto,
        'nomeProgetto' => $nomeProgetto,
        '@esito' => '@esito'
    ];

    $esito = $db->procedure('CreazioneReward', $paramsReward);

    if(!$esito) {
        AlertManager::setError('procedura', "Si è verificato un errore imprevisto nell'inserimento delle rewards del progetto!");
        header('location: /home/crea-progetto/conferma-dati');
        exit();
    }

    //logo reward
    $db_mongo->inserisciLog("Nuova reward ".$nomeFile." inserita per il progetto ".$nomeProgetto);
}

//eliminiamo tutte le variabili per la creazione del progetto
unset($_SESSION['creazione-progetto']);
unset($_SESSION['aggiunta-foto']);
unset($_SESSION['aggiunta-reward']);
unset($_SESSION['aggiunta-skill']);
unset($_SESSION['aggiunta-componente']);

AlertManager::setSuccess("Progetto creato!");
// mando l'utente ad una pagina in cui viene comunicato che il progetto è stato creato correttamente
header("location: /home/i-miei-progetti");
exit();