<? 

use \core\Validatore;

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
    $_SESSION['aggiunta-profilo'] = false;
    require view("/creazione-progetto/inserimento-profili.view.php", [
        "errori" => $errori
    ]);
    exit();
}

$profilo = [
    'nome' => $nome,
    'numero_posizioni' => $posizioni,
];

//controllo che non sia stata già aggiunta una skill uguale
foreach($_SESSION['creazione-progetto']['profili'] as $profilo){
    if($profilo['nome'] === $nome){
        $_SESSION['aggiunta-profilo'] = false;
        require view("/creazione-progetto/inserimento-profili.view.php", [
            "errori" => $errori
        ]);
        
        exit();
    }
}

//inserisco il profilo aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['profili'], $profilo);
$_SESSION['aggiunta-profilo'] = true;

//sposto tutte le skill che avevo memorizzato all'interno dell'array per il profilo 
foreach($_SESSION['creazione-progetto']['profili'] as $profilo) {
    if ($profilo['nome'] === $nome) {
        $profilo['skills-richieste'] = $_SESSION['creazione-progetto']['skills-richieste'];
        unset($_SESSION['creazione-progetto']['skills-richieste']); // pulisco le skill per inserirne altre per un altro profilo
    }
}

header('location: /home/crea-progetto/software/profili');
exit();