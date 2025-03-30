<?php

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

try {
    //avvio la transazione
    $db->beginTransaction();

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
        throw new Exception("Errore nell'inserimento del progetto, riprova");
    }

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
                throw new Exception("Errore nell'inserimento dei profili, riprova");
            }
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
                throw new Exception("Errore nell'inserimento delle componenti, riprova");
            }
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

        $paramsFoto = [
            'url' => $destinazione,
            'descrizione' => $descrizioneFoto,
            'nomeProgetto' => $nomeProgetto,
            '@esito' => '@esito'
        ];

        $esito = $db->procedure('InserimentoFotoProgetto', $paramsFoto);

        if(!$esito) {
            throw new Exception("Errore nell'inserimento delle foto, riprova");
        }
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

        $nomeFile = basename($urlTemporaneo);
        $destinazione = $directoryFotoRewards . '/' . $nomeFile;

        $paramsReward = [
            'url' => $destinazione,
            'descrizione' => $descrizioneReward,
            'nomeProgetto' => $nomeProgetto,
            '@esito' => '@esito'
        ];

        $esito = $db->procedure('CreazioneReward', $paramsReward);

        if(!$esito) {
            throw new Exception("Errore nell'inserimento delle rewards, riprova.");
        }
    }

    // committo le modifiche
    $db->commit();

    //INSERISCO I LOGS
    //progetto
    $db_mongo->inserisciLog("Nuovo progetto ".$nomeProgetto." creato da ".$email);

    //componenti o profili
    if($tipo === 'software') {
        foreach($_SESSION['creazione-progetto']['profili'] as $profilo) {
            $db_mongo->inserisciLog("Nuovo profilo ".$profilo['nome']." inserito per il progetto ".$nomeProgetto);
        }
    } else {
        foreach($_SESSION['creazione-progetto']['componenti'] as $componente) {
            $db_mongo->inserisciLog("Nuova componente ".$componente['nome']." inserita per il progetto ".$nomeProgetto);
        }
    }

    //foto
    foreach($_SESSION['creazione-progetto']['foto'] as $foto) {
        $urlTemporaneo = $foto['percorso'];
        $descrizioneFoto = $foto['descrizione'];

        $nomeFile = basename($urlTemporaneo);
        $destinazione = $directoryFotoProgetto . '/' . $nomeFile;
        
        //copio l'immagine nella nuova cartella e lo elimino dalla vecchia
        copy($urlTemporaneo, $destinazione);
        unlink($urlTemporaneo);

        $db_mongo->inserisciLog("Nuova foto ".basename($foto['percorso'])." inserita per il progetto ".$nomeProgetto);
    }

    //rewards
    foreach($_SESSION['creazione-progetto']['rewards'] as $reward) {
        $urlTemporaneo = $reward['urlFoto'];
        $descrizioneReward = $reward['descr'];

        $nomeFile = basename($urlTemporaneo);
        $destinazione = $directoryFotoRewards . '/' . $nomeFile;
        
        //copio l'immagine nella nuova cartella e lo elimino dalla vecchia
        copy($urlTemporaneo, $destinazione);
        unlink($urlTemporaneo);

        $db_mongo->inserisciLog("Nuova reward ".basename($reward['urlFoto'])." inserita per il progetto ".$nomeProgetto);
    }

    //eliminiamo tutte le variabili per la creazione del progetto
    rimuoviDatiCreazione();
    
    AlertManager::setSuccess("Progetto creato!");
} catch(Exception $e) {
    // annullo tutte le modifiche effettuate in caso di errore
    $db->rollback();
    AlertManager::setError('procedura', "Si è verificato un errore imprevisto: " . $e->getMessage());
    rimuoviDatiCreazione();
}

header("location: /home/i-miei-progetti");
exit();