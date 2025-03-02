<? 

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$nomeProgetto = $_POST['nome'];
$dataLimite = $_POST['data-limite'];
$descrizione = $_POST['descrizione'];
$budget = $_POST['budget'];
$tipo = $_POST['tipo'];

$errori = [];

if (!Validatore::isString($nomeProgetto, 1, 50)) {
    $errori["nome"] = "Nome del progetto non valido!";
}

if (!Validatore::isDate($dataLimite, date('d/m/Y'))) {
    $errori["data-limite"] = "La data limite deve essere maggiore della data corrente";
}

if (!Validatore::isString($descrizione, 1, 100)) {
    $errori["descrizione"] = "Descrizione troppo lunga!";
}

if (!Validatore::isNumber($budget, 1)) {
    $errori["budget"] = "Budget non valido!";
}

if (!empty($errori)) {
    require view("/creazione-progetto/crea-progetto.view.php", [
        "errori" => $errori
    ]);
    exit();
}

$query = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if (isset($query[0])) {
    $errori['procedura'] = "Nome del progetto già in uso!";
    require view("/creazione-progetto/crea-progetto.view.php", [
        "errori" => $errori
    ]);
    exit();
}

// Salvo informazioni di sessione per la creazione del progetto
$_SESSION['creazione-progetto'] = [
    'nome' => $nomeProgetto,
    'data-limite' => $dataLimite,
    'descrizione' => $descrizione,
    'budget' => $budget,
    'tipo' => $tipo,
    'componenti' => [],
    'profili' => [],
    'skills-richieste' => [],
    'foto' => [],
    'rewards' => [],
    'step1' => true,
    'step2' => false,
    'step3' => false,
    'step4' => false
];

if($tipo == 'hardware')
    header('location: /home/crea-progetto/hardware/componenti');
else
    header('location: /home/crea-progetto/software/profili');

exit();