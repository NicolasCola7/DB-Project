<? 

use \core\App;
use \core\Database;
use \core\Validatore;

$db = App::getContainer()->risolvi(Database::class);

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

header('location: /home/le-mie-skill');
exit();