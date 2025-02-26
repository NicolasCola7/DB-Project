<? 

use \core\Validatore;

$nome = $_POST['nome-skill'];
$livello = $_POST['livello'];


$errori = [];

if (!Validatore::isString($nome, 1, 50)) {
    $errori["nome"] = "Nome della skill non valido";
}

if (!Validatore::isNumber($livello, 1, 5)) {
    $errori["prezzo"] = "Il livello deve essere compreso tra 1 e 5!";
}

if (!empty($errori)) {
    require view("/creazione-progetto/inserimento-profili.view.php", [
        "errori" => $errori
    ]);
    
    $_SESSION['aggiunta-skill'] = false;
    exit();
}

$skill = [
    'nomeSkill' => $nome,
    'livello' => $livello,
];

//controllo che non sia stata già aggiunta una skill uguale
foreach($_SESSION['creazione-progetto']['skills-richieste'] as $skill_richiesta){
    if($skill_richiesta['nomeSkill'] === $nome){
        $_SESSION['aggiunta-skill'] = false;
        require view("/creazione-progetto/inserimento-profili.view.php", [
            "errori" => $errori
        ]);
        
        exit();
    }
}

//inserisco la componente aggiunta nell'apposita variabile di sessione
array_push($_SESSION['creazione-progetto']['skills-richieste'], $skill);
$_SESSION['aggiunta-skill'] = true;

header('location: /home/crea-progetto/software/profili');
exit();