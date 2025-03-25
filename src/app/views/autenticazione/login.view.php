<?php use core\AlertManager; ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bostarter </title>
    <link rel='stylesheet' type='text/css' href='/public/styles/autenticazione/login.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="titolo">
        <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin'): ?>
            <h1>BOSTARTER - AMMINISTRAZIONE</h1>
        <?php else: ?>
            <h1>BOSTARTER</h1>
        <?php endif; ?>
    </div>
    <div class="login-container">
        <h2>Accedi al tuo account</h2>
        <form action='<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin' ? "/admin/login" : "/login"; ?>' method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin'): ?>
                <div class="form-group">
                    <label for="codiceSicurezza">Codice sicurezza</label>
                    <input type="number" id="codiceSicurezza" name="codiceSicurezza" required min = "1" max = "9999">
                </div>
            <?php endif; ?>

            <button type="submit" class="login-btn">Login</button>

            <div class="links">
                <a href='<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin' ? '/admin/registrazione' : '/registrazione'; ?>'>
                    Non hai un account? Registrati
                </a>
                
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin'): ?>
                    <a href="/login" class="user-link">
                        Accedi come utente
                    </a>
                <?php else: ?>
                    <a href="/admin/login" class="admin-link">
                        Accedi come amministratore
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <?= AlertManager::show($errori ?? []) ?>
</body>
</html>