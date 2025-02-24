<? 

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$nome = $_POST['nome'];
$descrizione = $_POST['descrizione'];
$quantita = $_POST['quantità'];
$prezzo = $_POST['prezzo'];

$errori = [];

if (!Validatore::isString($nome, 1, 50)) {
    $errori["nome"] = "Nome del componente non valido";
}

if (!Validatore::isString($descrizione, 1, 100)) {
    $errori["descrizione"] = "Descrizione troppo lunga!";
}

if (!Validatore::isNumber($quantita, 1)) {
    $errori["quantità"] = "La quantità minima deve essere 1!";
}

if (!Validatore::isNumber($prezzo, 1)) {
    $errori["prezzo"] = "Il prezzo minimo deve essere 1!";
}

if (!empty($errori)) {
    require view("/creazione-progetto/inserimento-componenti.view.php", [
        "errori" => $errori
    ]);
    exit();
}

$componente = [
    'nome' => $nome,
    'descrizione' => $descrizione,
    'quantità' => $quantita,
    'prezzo' => $prezzo
];

//inserisco la componente aggiunta nell'apposita variabile di sessione

array_push($_SESSION['creazione-progetto']['componenti'], $componente);

exit();