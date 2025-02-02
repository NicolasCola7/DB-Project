<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['current_project'])) {
    header("Location: autenticazione.html");
    exit;
}

$host = 'localhost:3307';
$dbname = 'BOTSTARTER';
$user = 'username'; 
$pass = 'MatAleNic'; 
$rewards = [];
$error = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get available rewards
    $stmt = $conn->prepare("CALL MostraRewardDisponibili(?)");
    $stmt->execute([$_SESSION['current_project']]);
    $rewards = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = "Error loading rewards: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Choose Reward</title>
    <style>
        table { border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        .reward-form { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Available Rewards for <?= htmlspecialchars($_SESSION['current_project']) ?></h1>
    
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (empty($rewards)): ?>
        <p>No rewards available for this project</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Code</th>
                <th>Photo</th>
                <th>Description</th>
            </tr>
            <?php foreach ($rewards as $reward): ?>
                <tr>
                    <td><?= htmlspecialchars($reward['codice']) ?></td>
                    <td>
                        <?php if ($reward['foto']): ?>
                            <img src="<?= htmlspecialchars($reward['foto']) ?>" alt="Reward photo" style="max-width: 100px;">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($reward['descr']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <form class="reward-form" action="procedures.php" method="post">
            <input type="hidden" name="procedure" value="scelta_reward">
            <input type="hidden" name="progetto" value="<?= htmlspecialchars($_SESSION['current_project']) ?>">
            
            <label>Select Reward Code:
                <select name="codiceReward" required>
                    <option value="">Choose a reward</option>
                    <?php foreach ($rewards as $reward): ?>
                        <option value="<?= htmlspecialchars($reward['codice']) ?>">
                            <?= htmlspecialchars($reward['codice']) ?> - <?= htmlspecialchars($reward['descr']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            
            <button type="submit">Choose Reward</button>
        </form>
    <?php endif; ?>
    
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>