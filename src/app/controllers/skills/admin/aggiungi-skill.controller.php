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

if (!Validatore::isString($nomeSkill, 1, 50)) {
    AlertManager::setError("nome", "Nome della skill non valido!");
    header('location: /admin/home/gestione-skills');
}

$parametri = [
    'emailAmministratore' => $email,
    'nome' => $nomeSkill,
    '@esito' => '@esito'
];

$esito = $db->procedure('InserimentoCompetenza', $parametri);

if (!$esito) {
    AlertManager::setError('procedura', "Impossibile aggiungere la seguente competenza!");
    header('location: /admin/home/gestione-skills');
    exit();
}

$db_mongo->inserisciLog("Nuova skill ".$nomeSkill." aggiunta da ".$email);
header('location: /admin/home/gestione-skills');
exit();