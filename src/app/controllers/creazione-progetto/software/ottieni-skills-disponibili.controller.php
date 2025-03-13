<? 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$skills = $db->query('SELECT nome FROM Skill');

//controllo se l'url è stato richiesto con query string per differenziarlo dalla sezione crea-progetto
$iMieiProgetti= $_GET['modifica'] ?? '';

if(!$iMieiProgetti)
    require view('/creazione-progetto/inserimento-profili.view.php', $skills);
else
    require view ('/i-miei-progetti/inserimento-profilo.view.php', $skills);

exit();