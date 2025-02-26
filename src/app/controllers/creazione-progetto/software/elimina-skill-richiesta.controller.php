<?  

use \core\App;
use \core\Database;

// Recupero in neme della skill passato nella query string dell'url
$daEliminare = $_GET['nomeSkill'];

foreach($_SESSION['creazione-progetto']['skills-richieste'] as $skill) {
    if($skill['nomeSkill'] === $daEliminare) {
        unset($skill);
    }
}

exit();