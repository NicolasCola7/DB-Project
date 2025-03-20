<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bostarter | Login Admin</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/autenticazione/login.style.css'>

</head>
<body>
    <div class="titolo">
        <h1>BOSTARTER - AMMINISTRAZIONE</h1>
    </div>
    <div class="login-container">
        <h2>Accedi al tuo account</h2>
        <form action="/admin/login" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="codiceSicurezza">Codice sicurezza</label>
                <input type="number" id="codiceSicurezza" name="codiceSicurezza" required min = "1" max = "9999">
            </div>
            
            <div id="errori">
                <?php if (isset($errori['email'])) : ?>
                    <p> <?= $errori['email'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['password'])) : ?>
                    <p> <?= $errori['password'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['codiceSicurezza'])) : ?>
                    <p> <?= $errori['codiceSicurezza'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>

            <button type="submit" class="login-btn">Login</button>

            <div class="links">
                <a href='/admin/registrazione'>Non hai un account? Registrati</a>
                <a href="/login" class="user-link">Accedi come utente</a>
            </div>
        </form>
    </div>
</body>
</html>