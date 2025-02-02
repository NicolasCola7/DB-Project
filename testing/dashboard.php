<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.html");
    exit;
}

$host = 'localhost:3307';
$dbname = 'BOTSTARTER';
$user = 'username'; 
$pass = 'MatAleNic';  

// Initialize variables
$skill_options = '';
$skill_error = '';
$user_skills = [];
$skill_management_error = '';

try {
    // Fetch available skills
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all skills
    $stmt = $conn->query("SELECT nome FROM Skill ORDER BY nome");
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($skills)) {
        ob_start();
        foreach ($skills as $skill) {
            echo '<option value="' . htmlspecialchars($skill['nome']) . '">' 
                . htmlspecialchars($skill['nome']) . '</option>';
        }
        $skill_options = ob_get_clean();
    } else {
        $skill_error = '<option value="" disabled>No skills available</option>';
    }

    // Get user's existing skills
    $stmt = $conn->prepare("SELECT sp.nomeSkill, sp.livello 
                          FROM Skill_Possesso sp 
                          WHERE sp.emailUtente = ?");
    $stmt->execute([$_SESSION['email']]);
    $user_skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $skill_error = '<option value="" disabled>Error loading skills</option>';
    $skill_management_error = "Error loading current skills: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            width: 300px;
            float: left;
        }
        .clear {
            clear: both;
        }
        .skills-list {
            margin-top: 15px;
        }
        .skill-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .skill-name {
            font-weight: bold;
            margin-right: 10px;
        }
        .delete-form {
            margin-left: auto;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
    <a href="logout.php" style="float: right;">Logout</a>
    
    <div class="card">
        <h2>Add Skill</h2>
        <form action="procedures.php" method="post">
            <input type="hidden" name="procedure" value="inserimento_skill">
            <div>
                <label>Skill:</label>
                <select name="nomeSkill" required>
                    <option value="">Select a skill</option>
                    <?php
                    if (!empty($skill_options)) {
                        echo $skill_options;
                    } else {
                        echo $skill_error;
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Level (0-5):</label>
                <input type="number" name="livello" min="0" max="5" required>
            </div>
            <input type="submit" value="Add Skill">
        </form>
    </div>

    <div class="card">
        <h2>Your Skills</h2>
        <?php if (!empty($skill_management_error)): ?>
            <p class="error"><?= htmlspecialchars($skill_management_error) ?></p>
        <?php endif; ?>
        
        <?php if (!empty($user_skills)): ?>
            <div class="skills-list">
                <?php foreach ($user_skills as $skill): ?>
                    <div class="skill-item">
                        <span class="skill-name"><?= htmlspecialchars($skill['nomeSkill']) ?></span>
                        <span class="skill-level">(Level <?= $skill['livello'] ?>)</span>
                        <form class="delete-form" action="procedures.php" method="post">
                            <input type="hidden" name="procedure" value="delete_skill">
                            <input type="hidden" name="nomeSkill" value="<?= htmlspecialchars($skill['nomeSkill']) ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No skills added yet.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>Fund Project</h2>
        <form action="procedures.php" method="post">
            <input type="hidden" name="procedure" value="inserimento_finanziamento">
            <div>
                <label>Project Name:</label>
                <input type="text" name="progetto" required>
            </div>
            <div>
                <label>Amount:</label>
                <input type="number" name="importo" step="50" min="100" required>
            </div>
            <input type="submit" value="Fund Project">
        </form>
    </div>

    <div class="card">
        <h2>Open Projects</h2>
        <form action="procedures.php" method="post">
            <input type="hidden" name="procedure" value="visualizza_progetti">
            <input type="submit" value="View Open Projects">
        </form>
    </div>

    <div class="clear"></div>
</body>
</html>