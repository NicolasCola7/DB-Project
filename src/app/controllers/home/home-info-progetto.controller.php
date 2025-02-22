<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];

$progetto = $db->query("select P.nome, P.data_inserimento, P.data_limite, P.descr, P.stato, P.budget_avvio, P.tipoProgetto, P.emailCreatore, U.nome as nomeC, U.cognome as cognomeC
from Progetto P join Utente U on P.emailCreatore = U.email");

header("Location: /home/info-progetto");
exit;