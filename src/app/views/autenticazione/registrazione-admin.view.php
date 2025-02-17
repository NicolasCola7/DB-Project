<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Botstarter | Registrazione</title>
  <style>
    /* Reset per il box-sizing */
    * {
      box-sizing: border-box;
    }
    
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      background-color: #f0f2f5;
      min-height: 100vh;
      padding: 1rem;
    }

    .signup-container {
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
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

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"] {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #dadce0;
      border-radius: 4px;
    }

    .signup-btn {
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

    .signup-btn:hover {
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

    #errori {
      color: #d93025;
      margin-bottom: 1rem;
    }

    #errori p {
      margin: 0.5rem 0;
      font-size: 0.9rem;
    }

    #check {
      display: flex;
      align-items: center;
    }
    
    #check input[type="checkbox"] {
      margin: 0;
    }
    
    #check label {
      margin: 0;
      padding-left: 0.5rem;
    }
    
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Registrati</h2>
    <form action="/registrazione" method="POST">
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

      <div class="form-group">
        <label for="codiceSicurezza">Codice sicurezza</label>
        <input type="text" id="codiceSicurezza" name="codiceSicurezza">
      </div>
      
      <div id="errori">
        <?php if (isset($errori['email'])) : ?>
          <p><?= $errori['email'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['password'])) : ?>
          <p><?= $errori['password'] ?></p>
        <?php endif; ?>

        <?php if (isset($errori['procedura'])) : ?>
          <p><?= $errori['procedura'] ?></p>
        <?php endif; ?>

        <!-- TODO: Aggiungere altri controlli per possibili errori -->
      </div>

      <button type="submit" class="signup-btn">Registrati</button>

      <div class="links">
        <a href="/login">Hai già un account? Accedi</a>
      </div>
    </form>
  </div>
</body>
</html>
