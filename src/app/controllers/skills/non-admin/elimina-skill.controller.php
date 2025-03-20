<?  

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$email = $_SESSION['utente']['email'];

// Recupero in neme della skill passato nell'url
$daEliminare = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

$parametri = [
    'email' => $email,
    'nomeSkill' => $daEliminare,
    '@esito' => '@esito'
];

$db->procedure('RimozioneSkillCurriculum', $parametri);

$db_mongo->inserisciLog("Skill di curriculum ".$daEliminare." rimossa da ".$email);
header('location: /home/le-mie-skill');
exit();