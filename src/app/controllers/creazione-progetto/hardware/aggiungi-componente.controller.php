<? 

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

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
    
    $_SESSION['aggiunta-componente'] = false;
    exit();
}

$componenteDaInserire = [
    'nome' => $nome,
    'descrizione' => $descrizione,
    'quantità' => $quantita,
    'prezzo' => $prezzo
];

//controllo che non sia stata già aggiunta una componente uguale
foreach($_SESSION['creazione-progetto']['componenti'] as $componente){
    if($componente['nome'] === $nome){
        $_SESSION['aggiunta-componente'] = false;
        require view("/creazione-progetto/inserimento-componenti.view.php", [
            "errori" => $errori
        ]);
        
        exit();
    }
}

//inserisco la componente aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['componenti'], $componenteDaInserire);
$_SESSION['aggiunta-componente'] = true;

header('location: /home/crea-progetto/hardware/componenti');
exit();