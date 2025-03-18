<? 

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$skills = $db->query('SELECT nome FROM Skill');

//controllo da quale url è stato chiamato
$iMieiProgetti= urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti';

if(!$iMieiProgetti)
    require view('/creazione-progetto/inserimento-profili.view.php', $skills);
else
    require view ('/i-miei-progetti/inserimento-profilo.view.php', $skills);

exit();