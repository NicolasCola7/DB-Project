<?  

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

// Recupero in neme della skill passato nell'url
$daEliminare = urldecode(explode('/', $_SERVER['REQUEST_URI'])[4]);

$parametri = [
    ':nome' => $daEliminare,
];

$db->query('DELETE FROM Skill WHERE nome = :nome', $parametri);

header('location: /admin/home/gestione-skills');