<? 

use \core\App;
use \core\MySqlDatabase;
use \core\MongoDatabase;
use \core\Validatore;
use \core\AlertManager;

$db = App::getContainer()->risolvi(MySqlDatabase::class);
$db_mongo = App::getContainer()->risolvi(MongoDatabase::class);

$email = $_SESSION['utente']['email'];
$nomeSkill = $_POST['nome'];
$livello = $_POST['livello'];

$errori = [];

if (!Validatore::isString($nomeSkill, 1, 50)) {
    $errori["nome"] = "Nome delle skill non valido!";
}

if (!Validatore::isNumber($livello, 1, 5)) {
    $errori["livello"] = "Il lovello deve essere compreso tra 1 e 5!";
}

if (!empty($errori)) {
    require view("/skills/le-mie-skill.view.php", [
        "errori" => $errori
    ]);
    AlertManager::setWarning("Skill già inserita!");
    exit();
}

$parametri = [
    'emailUtente' => $email,
    'nomeSkill' => $nomeSkill,
    'livello' => $livello,
    '@esito' => '@esito'
];

$esito = $db->procedure('InserimentoSkillCurriculum', $parametri);

if (!$esito) {
    $errori['procedura'] =  "Impossibile aggiungere la seguente competenza!";
    require view("/skills/le-mie-skill.view.php", [
        'errori' => $errori
    ]);
    exit();
}

$db_mongo->inserisciLog("Nuova skill di curriculum ".$nomeSkill." aggiunta da ".$email);
AlertManager::setSuccess("Skill aggiunta.");
header('location: /home/le-mie-skill');
exit();