<? 

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

$skills = [];

$skillsGenerali = $db->query('SELECT nome FROM Skill WHERE nome NOT IN (SELECT nomeSkill FROM Skill_Possesso WHERE emailUtente = :email)', [':email' => $email]);
$skillsPossedute = $db->query('SELECT nomeSkill, livello FROM Skill_Possesso WHERE emailUtente = :email', [':email' => $email]);

$skills['generali'] = $skillsGenerali;
$skills['possedute'] = $skillsPossedute;

require view('/skills/le-mie-skill.view.php', $skills);

exit();