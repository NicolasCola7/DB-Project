<?  

use \core\App;
use \core\Database;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];

// Recupero in neme della skill passato nella query string dell'url
$daEliminare = $_GET['nomeSkill'];

$parametri = [
    'email' => $email,
    'nomeSkill' => $daEliminare,
    '@esito' => '@esito'
];

$db->procedure('RimozioneSkillCurriculum', $parametri);

exit();