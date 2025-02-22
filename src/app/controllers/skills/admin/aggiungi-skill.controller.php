<? 

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

$email = $_SESSION['utente']['email'];
$nomeSkill = $_POST['nome'];

$errori = [];

if (!Validatore::isString($nomeSkill, 1, 50)) {
    $errori["nome"] = "Nome della skill non valido!";
}

if (!empty($errori)) {
    require view("/skills/gestione-skills.view.php", [
        "errori" => $errori
    ]);
    exit();
}

$parametri = [
    'emailAmministratore' => $email,
    'nome' => $nomeSkill,
    '@esito' => '@esito'
];

$esito = $db->procedure('InserimentoCompetenza', $parametri);

if (!$esito) {
    $errori['procedura'] = "Impossibile aggiungere la seguente competenza!";
    require view("/skills/gestione-skills.view.php", [
        'errori' => $errori
    ]);
    exit();
}

header('location: /admin/home/gestione-skills');
exit();