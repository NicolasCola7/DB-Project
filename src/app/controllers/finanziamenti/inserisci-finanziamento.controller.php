<?php

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// ottengo il nome del progetto
$nomeProgetto = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

// controllo che il progetto esista 
$progettoEsistente = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if(!$progettoEsistente) {
    abort();
}

$errori = [];

//recupero l'importo del finanziamento
$importo = $_POST['importo'];

if(!Validatore::isNumber($importo, 1)) {
    $errori['importo'] = "L'importo deve essere un numero  maggiore di 0!";
    require view('/finanziamenti/inserisci-finanziamento.view.php', $errori);
    exit();
}

$parametri = [
    'nomeProgetto' => $nomeProgetto,
    'importo' => $importo,
    'emailUtente' => $email,
    '@esito' => '@esito'
];

$esito = $db->procedure('InserimentoFinanziamento', $parametri);

if(!$esito) {
    $errori['procedura'] ="Impossibile finanziare il seguente progetto. Importo eccedente il budget o hai già stato inviato un finanziamento in data odierna.";
    require view('/finanziamenti/inserisci-finanziamento.view.php', $errori);
    exit();
}


header('location: /home/progetti/'.urlencode($nomeProgetto).'/finanziamenti/scelta-reward');
exit();