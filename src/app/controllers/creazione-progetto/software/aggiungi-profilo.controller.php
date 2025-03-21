<? 

use \core\App;
use \core\Validatore;
use \core\AlertManager;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$nome = $_POST['nome'];
$posizioni = $_POST['posizioni'];

$errori = [];

if (!Validatore::isString($nome, 1, 50)) {
    $errori["nome"] = "Nome del profilo non valido!";
}

if (!Validatore::isNumber($posizioni, 1)) {
    $errori["posizioni"] = "Devi inserire almeno 1 posizione disponibile!";
}

//recupero le skills disponibili da passare in caso di errore
$skills = $db->query('SELECT nome FROM Skill');

if (!empty($errori)) {
    require view("/creazione-progetto/inserimento-profili.view.php", [
        "errori" => $errori,
        "skills" => $skills
    ]);
    
    AlertManager::setWarning("Profilo già inserito!");
    exit();
}


//recupero le skills
$skillsAggiunte = $_POST['skills'];
$skillsRichieste = [];
foreach($skillsAggiunte as $skill){
    array_push($skillsRichieste,['nomeSkill' => $skill['nome'], 'livello' => $skill['livello']]);
}

$profiloDaInserire = [
    'nome' => $nome,
    'numero_posizioni' => $posizioni,
    'skills-richieste' => $skillsRichieste
];


//controllo che non sia stato già inserito un profilo uguale uguale
foreach($_SESSION['creazione-progetto']['profili'] as $profilo){
    if($profilo['nome'] === $nome){
        AlertManager::setWarning("Profilo già inserito!");
        require view("/creazione-progetto/inserimento-profili.view.php", [
            "errori" => $errori,
            "skills" => $skills
        ]);
        exit();
    }
}

//inserisco il profilo aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['profili'], $profiloDaInserire);
AlertManager::setSuccess("Profilo aggiunto!");


header('location: /home/crea-progetto/software/profili');
exit();