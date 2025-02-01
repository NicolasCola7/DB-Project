<?php
session_start();
$host = 'localhost:3307';
$dbname = 'BOTSTARTER';
$user = 'username'; 
$pass = 'MatAleNic';  

try {
    // Establish a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$procedure = $_POST['procedure'];
$message = '';

try {
    switch ($procedure) {
        case 'autenticazione_normale':
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Hash the input password with MD5
            $hashedPassword = $password;

            // Call the stored procedure
            $stmt = $conn->prepare("CALL AutenticazioneNormale(:email, :password, @esito)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            // Retrieve the OUT parameter
            $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
            switch ($result['esito']) {
                case 0: $message = "User not found"; break;
                case 1: $message = "Wrong password"; break;
                case 2: 
                    $message = "Authentication successful!";
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    header("Location: dashboard.php");
                    break;
            }
            break;

        case 'autenticazione_admin':
            $email = $_POST['email'];
            $password = $_POST['password'];
            $codice = $_POST['codice'];

            
            $hashedPassword = $password;

            // Call the stored procedure
            $stmt = $conn->prepare("CALL AutenticazioneAmministratore(:email, :password, :codice, @esito)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':codice', $codice, PDO::PARAM_INT);
            $stmt->execute();

            // Retrieve the OUT parameter
            $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
            switch ($result['esito']) {
                case 0: $message = "Admin not found"; break;
                case 1: $message = "Wrong password"; break;
                case 2: $message = "Wrong code"; break;
                case 3: 
                    $message = "Admin authentication successful!";
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    header("Location: dashboard.php");
                    break;
            }
            break;

        case 'registrazione_normale':
            $fields = [
                'email' => $_POST['email'],
                'password' => $_POST['password'], 
                'nome' => $_POST['nome'],
                'cognome' => $_POST['cognome'],
                'luogo_nascita' => $_POST['luogo_nascita'],
                'anno_nascita' => $_POST['anno_nascita'],
                'nickname' => $_POST['nickname']
            ];

            // Call the stored procedure
            $stmt = $conn->prepare("CALL RegistrazioneNormale(:email, :password, :nome, :cognome, :luogo_nascita, :anno_nascita, :nickname, @esito)");
            $stmt->bindParam(':email', $fields['email']);
            $stmt->bindParam(':password', $fields['password']);
            $stmt->bindParam(':nome', $fields['nome']);
            $stmt->bindParam(':cognome', $fields['cognome']);
            $stmt->bindParam(':luogo_nascita', $fields['luogo_nascita']);
            $stmt->bindParam(':anno_nascita', $fields['anno_nascita'], PDO::PARAM_INT);
            $stmt->bindParam(':nickname', $fields['nickname']);
            $stmt->execute();

            // Retrieve the OUT parameter
            $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
            $message = $result['esito'] ? "Registration successful!" : "Registration failed (user exists)";
            break;

        case 'registrazione_creatore':
            $fields = [
                'email' => $_POST['email'],
                'password' => $_POST['password'], 
                'nome' => $_POST['nome'],
                'cognome' => $_POST['cognome'],
                'luogo_nascita' => $_POST['luogo_nascita'],
                'anno_nascita' => $_POST['anno_nascita'],
                'nickname' => $_POST['nickname']
            ];

            // Call the stored procedure
            $stmt = $conn->prepare("CALL RegistrazioneCreatore(:email, :password, :nome, :cognome, :luogo_nascita, :anno_nascita, :nickname, @esito)");
            $stmt->bindParam(':email', $fields['email']);
            $stmt->bindParam(':password', $fields['password']);
            $stmt->bindParam(':nome', $fields['nome']);
            $stmt->bindParam(':cognome', $fields['cognome']);
            $stmt->bindParam(':luogo_nascita', $fields['luogo_nascita']);
            $stmt->bindParam(':anno_nascita', $fields['anno_nascita'], PDO::PARAM_INT);
            $stmt->bindParam(':nickname', $fields['nickname']);
            $stmt->execute();

            // Retrieve the OUT parameter
            $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
            $message = $result['esito'] ? "Creator registration successful!" : "Registration failed (user exists)";
            break;

        case 'registrazione_admin':
            $fields = [
                'email' => $_POST['email'],
                'password' => $_POST['password'], // Hash the password with MD5
                'nome' => $_POST['nome'],
                'cognome' => $_POST['cognome'],
                'luogo_nascita' => $_POST['luogo_nascita'],
                'anno_nascita' => $_POST['anno_nascita'],
                'nickname' => $_POST['nickname'],
                'codice' => $_POST['codice']
            ];

            // Call the stored procedure
            $stmt = $conn->prepare("CALL RegistrazioneAmministratore(:email, :password, :nome, :cognome, :luogo_nascita, :anno_nascita, :nickname, :codice, @esito)");
            $stmt->bindParam(':email', $fields['email']);
            $stmt->bindParam(':password', $fields['password']);
            $stmt->bindParam(':nome', $fields['nome']);
            $stmt->bindParam(':cognome', $fields['cognome']);
            $stmt->bindParam(':luogo_nascita', $fields['luogo_nascita']);
            $stmt->bindParam(':anno_nascita', $fields['anno_nascita'], PDO::PARAM_INT);
            $stmt->bindParam(':nickname', $fields['nickname']);
            $stmt->bindParam(':codice', $fields['codice'], PDO::PARAM_INT);
            $stmt->execute();

            // Retrieve the OUT parameter
            $result = $conn->query("SELECT @esito AS esito")->fetch(PDO::FETCH_ASSOC);
            $message = $result['esito'] ? "Admin registration successful!" : "Registration failed (user exists)";
            break;

        default:
            $message = "Please select a procedure";
    }
} catch (PDOException $e) {
    $message = "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
}

$conn = null; // Close connection
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Result</title>
</head>
<body>
    <h1>Result:</h1>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="autenticazione.html">Back to Test</a>
</body>
</html>