<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: autenticazione.html");
    exit;
}

$host = 'localhost:3307';
$dbname = 'BOTSTARTER';
$user = 'username'; 
$pass = 'MatAleNic';  

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $procedure = $_POST['procedure'];
    $message = '';

    switch ($procedure) {
        case 'inserimento_skill':
            $stmt = $conn->prepare("CALL InserimentoSkillCurriculum(?, ?, ?, @esito)");
            $stmt->execute([
                $_SESSION['email'],
                $_POST['nomeSkill'],
                $_POST['livello']
            ]);
            $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
            $message = $result['esito'] ? "Skill added successfully!" : "Error: Invalid skill or level";
            break;

        case 'visualizza_progetti':
            $stmt = $conn->query("CALL VisualizzaProgettiAperti()");
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($projects) > 0) {
                $message = '<h2>Open Projects</h2><table border="1">';
                $message .= '<tr><th>Name</th><th>Description</th><th>Budget</th><th>Deadline</th></tr>';
                foreach ($projects as $project) {
                    $message .= sprintf(
                        '<tr><td>%s</td><td>%s</td><td>€%.2f</td><td>%s</td></tr>',
                        htmlspecialchars($project['nome']),
                        htmlspecialchars($project['descr']),
                        $project['budget_avvio'],
                        $project['data_limite']
                    );
                }
                $message .= '</table>';
            } else {
                $message = "No open projects found";
            }
            break;

            case 'inserimento_finanziamento':
                $progetto = $_POST['progetto'];
                $importo = $_POST['importo'];
                $email = $_SESSION['email'];
            
                $stmt = $conn->prepare("CALL InserimentoFinanziamento(?, ?, ?, @esito)");
                $stmt->execute([$progetto, $importo, $email]);
                $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
                
                switch ($result['esito']) {
                    case 0: 
                        $message = "Error: Invalid project or user";
                        break;
                    case 1: 
                        $message = "Error: Funding exceeds budget";
                        break;
                    case 2: 
                        // Store in session for reward selection
                        $_SESSION['current_project'] = $progetto;
                        $_SESSION['current_email'] = $email;
                        header("Location: scelta-reward.php");
                        exit;
                    break;
                }
                break;

            case 'delete_skill':
                $nomeSkill = $_POST['nomeSkill'];
                $email = $_SESSION['email'];
                
                $stmt = $conn->prepare("CALL RimozioneSkillCurriculum(?, ?, @esito)");
                $stmt->execute([$email, $nomeSkill]);
                $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
                
                $message = $result['esito'] 
                    ? "Skill deleted successfully!" 
                    : "Skill not found or already removed";
            break;

            case 'scelta_reward':
                if (!isset($_SESSION['loggedin']) || !isset($_SESSION['current_email'])) {
                    header("Location: autenticazione.html");
                    exit;
                }
            
                $codiceReward = $_POST['codiceReward'];
                $progetto = $_POST['progetto'];
                $email = $_SESSION['current_email'];
            
                try {
                    $stmt = $conn->prepare("CALL SceltaReward(?, ?, ?)");
                    $stmt->execute([$codiceReward, $email, $progetto]);
                    
                    if ($stmt->rowCount() > 0) {
                        $message = "Reward selected successfully!";
                    } else {
                        $message = "Error: Invalid reward selection";
                    }
                    
                    // Clear session variables
                    unset($_SESSION['current_project']);
                    unset($_SESSION['current_email']);
            
                } catch(PDOException $e) {
                    $message = "Error selecting reward: " . $e->getMessage();
                }
                break;
        case "crea_progetto":
            if(empty($_POST['txtNome']) || empty($_POST['txtDataLimite']) || empty($_POST['txtDescr']) || empty($_POST['txtBudget']) || empty($_POST['txtTipo'])){
                throw new InvalidArgumentException("Tutti i campi sono obbligatori");
                exit;
            }
            $nome = trim($_POST['txtNome']);
            
            $dataLimite = new DateTime($_POST['txtDataLimite']);
            $descrizione = trim($_POST['txtDescr']);
            $budget = trim($_POST['txtBudget']);
            $tipo = trim($_POST['txtTipo']);

            if($budget <= 0){
                throw new InvalidArgumentException("Il budget deve essere un valore positivo");
                exit;
            }
            
            if($dataLimite < new DateTime()){
                throw new InvalidArgumentException("La data limite deve essere futura");
            }
            $stmt = $conn->prepare("CALL CreazioneProgetto(:nome, :dataLimite, :descrizione, :budget, :tipo, :emailCreatore)");
            $stmt->bindValue(":nome",$nome);
            $stmt->bindValue(":dataLimite",$dataLimite->format('Y-m-d'));
            $stmt->bindValue(":descrizione",$descrizione);
            $stmt->bindValue(":budget",$budget);
            $stmt->bindValue(":tipo",$tipo);
            $stmt->bindValue(":emailCreatore",$_SESSION["email"]);

            $stmt->execute();
            header("Location: dashboard.php");
            break;
        case "addRewardsToProject":
            //controllo che tutti i campi siano compilati
            if(empty($_POST["txtCodReward"]) || empty($_POST["txtUrlImg"]) || empty($_POST["txtDescr"])){
                throw new InvalidArgumentException("Tutti i campi sono obbligatori");
                exit;
            }
            $codiceReward = trim($_POST["txtCodReward"]);
            $urlImg = trim($_POST["txtUrlImg"]);
            $descrizione = trim($_POST["txtDescr"]);
            $nomeProg = $_POST["slcProgetti"];

            /*
                Il metodo ctype_digit controlla che la stringa contenga solo cifre. Dopo di che
                provo a convertire la stringa in un intero tramite cast e controllo se è maggiore di zero
            */
            if(!ctype_digit($codiceReward) || !(int)$codiceReward > 0){
                throw new InvalidArgumentException("Il codice inserito deve essere un numero intero maggiore di zero");
                exit;
            }

            /*
                Il metodo filter_var controlla se la stringa $urlImg sia in formato URL (forse da togliere poi ne parliamo)
                Tramite il metodo preg_match e l'espressione regolare controlliamo che la stringa termini con un'estensione di immagine
            */
            if(/*!filter_var($urlImg, FILTER_VALIDATE_URL) ||*/ !preg_match('/\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i',$urlImg)){
                throw new InvalidArgumentException("Il nome dell'immagine deve essere nel formato 'nome.estensione'");
                exit;
            }
            $stmt = $conn->prepare("CALL CreazioneReward(:codice, :foto, :descrizione, :nomeProg)");
            $stmt->bindValue(":codice", $codiceReward);
            $stmt->bindValue(":foto", $urlImg);
            $stmt->bindValue(":descrizione", $descrizione);
            $stmt->bindValue(":nomeProg", $nomeProg);
            
            $stmt->execute();
            header("Location: dashboard.php");
            break;

    }

} catch(PDOException $e) {
    $message = "Database Error: " . $e->getMessage();
} catch(InvalidArgumentException $e){
    $message = "Errore in input: ".$e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Procedure Result</title>
</head>
<body>
    <?php echo $message; ?>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>