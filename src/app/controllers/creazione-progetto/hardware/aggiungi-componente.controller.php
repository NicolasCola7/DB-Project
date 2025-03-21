<? 

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$nome = $_POST['nome'];
$descrizione = $_POST['descrizione'];
$quantita = $_POST['quantita'];
$prezzo = $_POST['prezzo'];

$errori = [];

if (!Validatore::isString($nome, 1, 50)) {
    $errori["nome"] = "Nome del componente non valido";
}

if (!Validatore::isString($descrizione, 1, 100)) {
    $errori["descrizione"] = "Descrizione troppo lunga!";
}

if (!Validatore::isNumber($quantita, 1)) {
    $errori["quantita"] = "La quantita minima deve essere 1!";
}

if (!Validatore::isNumber($prezzo, 1)) {
    $errori["prezzo"] = "Il prezzo minimo deve essere 1!";
}

if (!empty($errori)) {
    require view("/creazione-progetto/inserimento-componenti.view.php", [
        "errori" => $errori
    ]);
    
    AlertManager::setWarning("Componente gia inserita!");
    exit();
}

$componenteDaInserire = [
    'nome' => $nome,
    'descrizione' => $descrizione,
    'quantita' => $quantita,
    'prezzo' => $prezzo
];

//controllo che non sia stata gia aggiunta una componente uguale
foreach($_SESSION['creazione-progetto']['componenti'] as $componente){
    if($componente['nome'] === $nome){
        AlertManager::setWarning("Componente gia inserita!");
        require view("/creazione-progetto/inserimento-componenti.view.php", [
            "errori" => $errori
        ]);
        
        exit();
    }
}

//inserisco la componente aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['componenti'], $componenteDaInserire);
AlertManager::setSuccess("Componente aggiunta!");

header('location: /home/crea-progetto/hardware/componenti');
exit();