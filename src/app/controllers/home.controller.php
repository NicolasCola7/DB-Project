<?php

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_SESSION['utente']['email'];
// Controlla se l'utente è un amministratore
$resultAdmin = $db->query("SELECT EXISTS (SELECT 1 FROM Amministratore WHERE emailAmministratore = :email) AS esiste", [':email' => $email]);
//controllo se la query ha restituito un risultato, nel caso lo salvo all'interno della variabile di sessione
$_SESSION['utente']['checkAdmin'] = !empty($resultAdmin) ? (bool) $resultAdmin[0]['esiste'] : false;

// Controlla se l'utente è un creatore
$resultCreatore = $db->query("SELECT EXISTS (SELECT 1 FROM Creatore WHERE emailCreatore = :email) AS esiste", [':email' => $email]);
//controllo se la query ha restituito un risultato, nel caso lo salvo all'interno della variabile di sessione
$_SESSION['utente']['checkCreatore'] = !empty($resultCreatore) ? (bool) $resultCreatore[0]['esiste'] : false;
$_SESSION['utente']['nome'] = $db->query("SELECT nome FROM Utente where email = :email", [':email' => $email])[0]['nome'];
header("Location: /home"); // Reindirizza alla view
exit;