<?  

use \core\App;
use \core\Database;

// Recupero in neme della skill passato nella query string dell'url
$daEliminare = $_GET['nomeSkill'];

foreach ($_SESSION['creazione-progetto']['skills-richieste'] as $key => $skill) {
    if ($skill['nomeSkill'] === $daEliminare) {
        unset($_SESSION['creazione-progetto']['skills-richieste'][$key]);
        break;
    }
}

// Re-index the array to ensure sequential numeric keys
$_SESSION['creazione-progetto']['skills-richieste'] = array_values($_SESSION['creazione-progetto']['skills-richieste']);

header('location: /home/crea-progetto/software/profili/skills');
exit();