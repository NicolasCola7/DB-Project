<?  

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

// Recupero in neme della skill passato nell'url
$daEliminare = urldecode(explode('/', $_SERVER['REQUEST_URI'])[4]);

$parametri = [
    ':nome' => $daEliminare,
];

$db->query('DELETE FROM Skill WHERE nome = :nome', $parametri);

$db_mongo->inserisciLog("Skill ".$daEliminare." eliminata da ".$_SESSION['utente']['email']);
header('location: /admin/home/gestione-skills');