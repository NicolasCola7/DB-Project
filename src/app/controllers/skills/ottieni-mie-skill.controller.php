<? 
header('Content-Type: application/json'); 

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];
$skills = $db->query('SELECT nomeSkill, livello FROM Skill_Possesso WHERE emailUtente = :email', [':email' => $email]);

echo json_encode($skills);