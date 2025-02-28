<?php
header('Content-Type: application/json');

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

// Query per la classifica creatori
$classificaCreatori = $db->query("SELECT * FROM ClassificaCreatoriAffidabilita");

// Query per i progetti vicini al completamento
$progettiVicini = $db->query("SELECT * FROM ProgettiApertiCompletamentoFinanziamento");

// Query per la classifica finanziatori
$classificaFinanziatori = $db->query("SELECT * FROM ClassificaUtentiFinanziatori");

// Creazione di un array JSON
$response = [
    'classificaCreatori' => $classificaCreatori,
    'progettiVicini' => $progettiVicini,
    'classificaFinanziatori' => $classificaFinanziatori
];

echo json_encode($response);