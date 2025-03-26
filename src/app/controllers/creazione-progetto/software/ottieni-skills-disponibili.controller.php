<? 

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$skills = $db->query('SELECT nome FROM Skill');

require view('/creazione-progetto/inserimento-profili.view.php', $skills);
exit();