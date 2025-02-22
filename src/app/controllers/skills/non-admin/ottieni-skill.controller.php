<? 
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

$skills = $db->query('SELECT nome FROM Skill WHERE nome NOT IN (SELECT nomeSkill FROM Skill_Possesso WHERE emailUtente = :email)', [':email' => $email]);

echo json_encode($skills);