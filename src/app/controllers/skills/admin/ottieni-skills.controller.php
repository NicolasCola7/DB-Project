<? 

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$skills = $db->query('SELECT nome FROM Skill');

require view('/skills/gestione-skills.view.php', $skills);

exit();