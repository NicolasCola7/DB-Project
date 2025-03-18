<?php

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

// Query per la classifica creatori
$classificaCreatori = $db->query("SELECT * FROM ClassificaCreatoriAffidabilita");

// Query per i progetti vicini al completamento
$progettiVicini = $db->query("SELECT * FROM ProgettiApertiCompletamentoFinanziamento");

// Query per la classifica finanziatori
$classificaFinanziatori = $db->query("SELECT * FROM ClassificaUtentiFinanziatori");

require view(
    '/statistiche/vedi-statistiche.view.php',
    [
        'classificaCreatori' => $classificaCreatori,
        'progettiVicini' => $progettiVicini,
        'classificaFinanziatori' => $classificaFinanziatori
    ]
);
exit();