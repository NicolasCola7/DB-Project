<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' type='text/css' href='/public/styles/autenticazione/registrazione.style.css'>
  <title>Bostarter | Registrazione</title>
</head>
<body>
  <div class="signup-container">
    <h2>Registrati</h2>
    <form action="/admin/registrazione" method="POST">
      <?php require view('/autenticazione/registrazione-form-base.view.php'); ?>

      <div class="form-group">
        <label for="codiceSicurezza">Codice sicurezza</label>
        <input type="text" id="codiceSicurezza" name="codiceSicurezza">
      </div>
      
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
        <a href="/admin/login">Hai già un account? Accedi</a>
      </div>
    </form>
  </div>
</body>
</html>
