<?php use core\AlertManager; ?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' type='text/css' href='/public/styles/autenticazione/registrazione.style.css'>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Bostarter</title>
</head>
<body>
  <div class="signup-container">
    <h2>Registrati</h2>
    <form action='<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin' ? "/admin/registrazione" : "/registrazione"; ?>' method="POST">
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>
      </div>

      <div class="form-group">
        <label for="cognome">Cognome</label>
        <input type="text" id="cognome" name="cognome" required>
      </div>

      <div class="form-group">
        <label for="luogo-nascita">Luogo di nascita</label>
        <input type="text" id="luogo-nascita" name="luogo-nascita" required>
      </div>

      <div class="form-group">
        <label for="anno-nascita">Anno di nascita</label>
        <input type="number" id="anno-nascita" name="anno-nascita" required min=1900>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="nickname">Nickname</label>
        <input type="text" id="nickname" name="nickname" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="conferma-password">Conferma Password</label>
        <input type="password" id="conferma-password" name="conferma-password" required>
      </div>

      <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin'): ?>
        <div class="form-group">
          <label for="codiceSicurezza">Codice sicurezza</label>
          <input type="text" id="codiceSicurezza" name="codiceSicurezza">
        </div>
      <?php else: ?>
        <div class="form-group" id="check">
          <input type="checkbox" id="check-creatore" name="check-creatore">
          <label for="check-creatore">Utente creatore</label>
        </div>
      <?php endif; ?>
      
      <div id="errori">
        <?php if (isset($errori['nome'])) : ?>
          <p><?= $errori['nome'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['cognome'])) : ?>
          <p><?= $errori['cognome'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['luogo_nascita'])) : ?>
          <p><?= $errori['luogo_nascita'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['anno_nascita'])) : ?>
          <p><?= $errori['anno_nascita'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['email'])) : ?>
          <p><?= $errori['email'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['nickname'])) : ?>
          <p><?= $errori['nickname'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['password'])) : ?>
          <p><?= $errori['password'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['password_errate'])) : ?>
          <p><?= $errori['password_errate'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['codice'])) : ?>
          <p><?= $errori['codice'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['procedura'])) : ?>
          <p><?= $errori['procedura'] ?></p>
        <?php endif; ?>

      </div>

      <button type="submit" class="signup-btn">Registrati</button>

      <div class="links">
          <a href='<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[1]) === 'admin'? "/admin/login" : "/login" ?>'>
            Hai già un account? Accedi
          </a>
      </div>
    </form>
    <?= AlertManager::show($errori ?? []) ?>
  </div>
</body>
</html>
