<? 

use \core\App;
use \core\MySqlDatabase;
use \core\Validatore;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$nomeProgetto = $_POST['nome'];
$dataLimite = $_POST['data-limite'];
$descrizione = $_POST['descrizione'];
$budget = $_POST['budget'];
$tipo = $_POST['tipo'];

if (!Validatore::isString($nomeProgetto, 1, 50)) {
     AlertManager::setError("nome", "Nome del progetto non valido!");
}

if (!Validatore::isDate($dataLimite, date('d/m/Y'))) {
     AlertManager::setError("data-limite", "La data limite deve essere maggiore della data corrente");
}

if (!Validatore::isString($descrizione, 1, 100)) {
     AlertManager::setError("descrizione", "Descrizione non valida o troppo lunga!");
}

if (!Validatore::isNumber($budget, 1)) {
     AlertManager::setError("budget", "Budget deve essere > 1");
}

if (!empty($_SESSION['errore'])) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}

$query = $db->query("SELECT nome FROM Progetto WHERE nome = :nome", [':nome' => $nomeProgetto]);

if (isset($query[0])) {
    AlertManager::setError('procedura', "Nome del progetto gia in uso!");
    header('location: /home/crea-progetto/informazioni-base');
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