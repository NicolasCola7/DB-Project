<?  

use \core\App;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$email = $_SESSION['utente']['email'];

// Recupero in neme della skill passato nell'url
$daEliminare = urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]);

$parametri = [
    'email' => $email,
    'nomeSkill' => $daEliminare,
    '@esito' => '@esito'
];

$db->procedure('RimozioneSkillCurriculum', $parametri);

header('location: /home/le-mie-skill');
exit();