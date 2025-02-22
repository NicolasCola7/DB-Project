<?  

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

// Recupero in neme della skill passato nella query string dell'url
$daEliminare = $_GET['nome'];

$parametri = [
    ':nome' => $daEliminare,
];

$db->query('DELETE FROM Skill WHERE nome = :nome', $parametri);

exit();