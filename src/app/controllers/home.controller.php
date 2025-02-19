<?php
session_start();

use \core\App;
use \core\Database;
use \core\Validatore;

// Ottiene un'istanza della classe Database dal container dell'applicazione
$db = App::getContainer()->risolvi(Database::class);

// Recupera i dati inviati dal form tramite il metodo POST
$email = $_POST['email'];

$_SESSION['checkAdmin'] = $db->query("SELECT EXISTS (SELECT * FROM Amministratore WHERE email = :email", [':email' => $email]);
$_SESSION['checkCreatore'] = $db->query("SELECT EXISTS (SELECT * FROM Creatore WHERE email = :email", [':email' => $email]);

header("Location: /home"); // Reindirizza alla view
exit;