<? 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$skills = $db->query('SELECT nome FROM Skill');

require view('/skills/gestione-skills.view.php');

exit();