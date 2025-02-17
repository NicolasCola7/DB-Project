<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Botstarter | Login </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            max-width: 100%;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            height: 80%;
            margin-bottom: 40px;
        }

        h2 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #5f6368;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #dadce0;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background-color: #1557b0;
        }

        .links {
            margin-top: 1.5rem;
            text-align: center;
        }

        .links a {
            color: #1a73e8;
            text-decoration: none;
            display: block;
            margin: 0.5rem 0;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .admin-link {
            color: #d93025 !important;
            margin-top: 1rem !important;
        }

        #errori {
            color: #d93025 !important;
        }
        .titolo{
            width: 100%;
            height: 8%;
            display: flex;
            justify-content: center;
            border-bottom: 1px solid lightgrey;
            text-align: center;
            background-color: white;
            margin-bottom: 30px;
            align-items: center;
            color: #1a73e8;;
        }
        
    </style>
</head>
<body>
    <div class="titolo">
        <h1>BOSTARTER</h1>
    </div>
    <div class="login-container">
        <h2>Accedi al tuo account</h2>
        <form action="/login" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div id="errori">
                <?php if (isset($errori['email'])) : ?>
                    <p> <?= $errori['email'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['password'])) : ?>
                    <p> <?= $errori['password'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>

            <button type="submit" class="login-btn">Login</button>

            <div class="links">
                <a href="/registrazione">Non hai un account? Registrati</a>
                <a href="/recupero-password">Password dimenticata?</a>
                <a href="/admin/login" class="admin-link">Accesso amministratore</a>
            </div>
        </form>
    </div>
</body>
</html>