<?  

// Recupero in neme della skill passato nell'url
$daEliminare = urldecode(explode('/', $_SERVER['REQUEST_URI'])[6]);

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