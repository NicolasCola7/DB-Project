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
    }

} catch(PDOException $e) {
    $message = "Database Error: " . $e->getMessage();
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