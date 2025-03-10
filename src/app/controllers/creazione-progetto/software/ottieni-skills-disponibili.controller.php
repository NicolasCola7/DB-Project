<? 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$skills = $db->query('SELECT nome FROM Skill');

require view('/creazione-progetto/inserimento-profili.view.php', $skills);

exit();