<? 

use \core\Validatore;
use \core\AlertManager;

$nome = $_POST['nome'];
$posizioni = $_POST['posizioni'];

$errori = [];

if (!Validatore::isString($nome, 1, 50)) {
    $errori["nome"] = "Nome del profilo non valido!";
}

if (!Validatore::isNumber($posizioni, 1)) {
    $errori["posizioni"] = "Devi inserire almeno 1 posizione disponibile!";
}

if (!empty($errori)) {
    require view("/creazione-progetto/inserimento-profili.view.php", [
        "errori" => $errori
    ]);
    
    AlertManager::setWarning("Profilo già inserito!");
    exit();
}

$profiloDaInserire = [
    'nome' => $nome,
    'numero_posizioni' => $posizioni,
];

//controllo che non sia stato già inserito un profilo uguale uguale
foreach($_SESSION['creazione-progetto']['profili'] as $profilo){
    if($profilo['nome'] === $nome){
        AlertManager::setWarning("Profilo già inserito!");
        require view("/creazione-progetto/inserimento-profili.view.php", [
            "errori" => $errori
        ]);
        exit();
    }
}

//inserisco il profilo aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['profili'], $profiloDaInserire);
AlertManager::setSuccess("Profilo aggiunto!");

//sposto tutte le skill che avevo memorizzato all'interno dell'array per il profilo 
foreach($_SESSION['creazione-progetto']['profili'] as $key=>$profilo) {
    if ($profilo['nome'] === $nome) {
        $_SESSION['creazione-progetto']['profili'][$key]['skills-richieste'] = $_SESSION['creazione-progetto']['skills-richieste'];
        $_SESSION['creazione-progetto']['skills-richieste'] = []; // pulisco le skill per inserirne altre per un altro profilo
    }
}

header('location: /home/crea-progetto/software/profili');
exit();