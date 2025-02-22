<? 
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$skills = $db->query('SELECT nome FROM Skill');

echo json_encode($skills);