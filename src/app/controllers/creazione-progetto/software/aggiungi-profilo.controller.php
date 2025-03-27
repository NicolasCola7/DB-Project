<? 

use \core\App;
use \core\Validatore;
use \core\AlertManager;
use \core\MySqlDatabase;

$db = App::getContainer()->risolvi(MySqlDatabase::class);

$nome = $_POST['nome'];
$posizioni = $_POST['posizioni'];

if (!Validatore::isString($nome, 1, 50)) {
     AlertManager::setError("nome", "Nome del profilo non valido!");
}

if (!Validatore::isNumber($posizioni, 1, 100)) {
     AlertManager::setError("posizioni", "Devi inserire almeno 1 e massimo 100 posizioni disponibili!");
}

if (!empty($_SESSION['errore'])) {
    header('location: /home/crea-progetto/software/profili');
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
        header('location: /home/crea-progetto/software/profili');
        exit();
    }
}

//inserisco il profilo aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['profili'], $profiloDaInserire);
AlertManager::setSuccess("Profilo aggiunto!");
$_SESSION["creazione-progetto"]["step2"] = true;
header('location: /home/crea-progetto/software/profili');
exit();