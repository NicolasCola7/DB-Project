<?php

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$errori = [];

$email = $_SESSION['uetente']['email'];
$nomeProgetto = $_SESSION['creazione-progetto']['nome'];
$dataLimite = $_SESSION['creazione-progetto']['data-limite'];
$budget = $_SESSION['creazione-progetto']['budget'];
$tipo = $_SESSION['creazione-progetto']['tipo'];
$descrizione = $_SESSION['creazione-progetto']['descrizione'];

$params_progetto = [
    'nome' => $nomeprogetto,
    'data-limite' => $dataLimite,
    'descrizione' => $descrizione,
    'budget' => $budget,
    'tipo' => $tipo,
    'emailCreatore' => $email,
    '@esito' => 'esito'
];

// inseriment o progetto
$esito = $db->procedure('CreazioneProgetto', $params_progetto);

if (!$esito) {
    $errori['procedura'] =  "Si è verificato un errore imprevisto nella creazione del progetto!";
    require view("/creazione-progetto/conferma-dati.view.php", [
        'errori' => $errori
    ]);
    exit();
}

// inserimento componenti o profili
if($tipo === 'software') {
    foreach($_SESSION['creazione-progetto']['profili'] as $profilo) {
        $nomeProfilo = $profilo['nome'];
        $posizioniDisponibili = $profilo['numero_posizioni'];

        $paramsProfilo = [
            'nome' => $nomeProfilo,
            'nomeProgetto' => $nomeProgetto,
            'posizioni-disponibili' => $posizioniDisponibili,
            '@esito' => 'esito'
        ];

        // inserisco profilo
        $esito = $db->procedure('InserimentoProfilo', $paramsProfilo);

        if (!$esito) {
            $errori['procedura'] =  "Si è verificato un errore imprevisto nella creazione dei profili!";
            require view("/creazione-progetto/conferma-dati.view.php", [
                'errori' => $errori
            ]);
            exit();
        }

        // inserisco skills richieste per il profilo
        $skills = $profilo['skills-richieste'];
        foreach( $skills as $skill) {
            $paramsSkill = [
                'nomeSkill' => $skill['nomeSkill'],
                'livello' => $skill['livello'],
                'nomeProfilo' => $nomeProfilo,
                'nomeProgetto' => $nomeProgetto,
                '@esito' => 'esito'
            ];

            //TODO: implementa procedura inserimento skill richiesta e correggi quella di ins profilo
            //$esito = $db->procedure('InserimentoSkillRichiesta, $paramsSkill);

            if (!$esito) {
                $errori['procedura'] =  "Si è verificato un errore imprevisto nella creazione delle skill richieste!";
                require view("/creazione-progetto/conferma-dati.view.php", [
                    'errori' => $errori
                ]);
                exit();
            }
        }
    }
} else {
    foreach($_SESSION['creazione-progetto']['componenti'] as $componente) {
        $nomeComponente = $componente['nome'];
        $descrizioneComponente = $componente['descrizione'];
        $prezzoComponente = $componente['prezzo'];
        $quantitaComponente = $componente['quantità'];

        $paramsComponente = [
            'nomeComponente' => $nomeComponente,
            'nomeProgetto' => $nomeProgetto,
            'descrizione' => $descrizioneComponente,
            'prezzo' => $prezzoComponente,
            'quantità' => $quantitaComponente,
            '@esito' => 'esito'
        ];

        $esito = $db->procedure('InserimentoComponenteHardware', $paramsComponente);

        if (!$esito) {
            $errori['procedura'] =  "Si è verificato un errore imprevisto nella creazione delle componenti hardware!";
            require view("/creazione-progetto/conferma-dati.view.php", [
                'errori' => $errori
            ]);
            exit();
        }
    }
}

//inserimento foto

// creo una nuova cartella definitiva per questo progetto ed elimino quella temporanea
$cartellaUtente = md5($_SESSION['utente']['nickname']);
$directoryFotoProgetto = 'public/immagini/progetti/'.$nomeProgetto.'/foto';

if (!file_exists($directoryFotoProgetto)) {
    mkdir($directoryFotoProgetto, 0770, true);// 0750 è il codice per gestire accessi alla directory
}

foreach($_SESSION['creazione-progetto']['foto'] as $foto) {
    $urlTemporaneo = $foto['percorso'];
    $descrizioneFoto = $foto['descrizione'];

    //TODO: ricava il nome della foto
    $nuovoUrl = $directoryFotoProgetto.'/'.'nomefile';

    // sposto la foto nella nuova cartella definitiva
    move_uploaded_file($urlTemporaneo, $nuovoUrl);

    $paramsFoto = [
        'url' => $nuovoUrl,
        'descrizione' => $descrizioneFoto,
        'nomeProgetto' => $nomeProgetto,
        '@esito' => 'esito'
    ];
    //$esito = $db->procedure('InserimentoFotoProgetto', $paramsFoto);

}


//inserimento rewards

// creo directory definitiva per reward di questo progetto
$directoryFotoRewards = 'public/immagini/progetti/'.$nomeProgetto.'/foto-rewards';

if (!file_exists($directoryFotoRewards)) {
    mkdir($directoryFotoRewards, 0770, true);// 0750 è il codice per gestire accessi alla directory
}
foreach($_SESSION['creazione-progetto']['rewards'] as $reward) {
    $urlTemporaneo = $reward['url'];
    $descrizioneReward = $reward['dessc'];

    //TODO: ricava il nome della foto
    $nuovoUrl = $directoryFotoRewards.'/'.'nomefile';

    // sposto la foto nella nuova cartella definitiva
    move_uploaded_file($urlTemporaneo, $nuovoUrl);

    $paramsReward = [
        'url' => $nuovoUrl,
        'descrizione' => $descrizioneFoto,
        'nomeProgetto' => $nomeProgetto,
        '@esito' => 'esito'
    ];

    //TODO: correggi procedura creazione reward, non ci va emailCreatore
    
    //$esito = $db->procedure('CreazioneReward', $paramsReward);

}

//TODO: rimuovi la directory temporanea dopo aver inserito rewards

