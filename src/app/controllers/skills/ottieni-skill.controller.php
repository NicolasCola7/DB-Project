<? 
use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESION['utente']['email'];
$skills = $db->query('SELECT nomeSkill, livello FROM Skill_Possesso WHERE emailUtente = :email', [':email' => $email]);

return json_encode($skills);