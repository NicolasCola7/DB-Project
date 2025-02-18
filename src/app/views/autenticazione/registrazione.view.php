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

      <div class="form-group" id="check">
        <input type="checkbox" id="check-creatore" name="check-creatore">
        <label for="check-creatore">Utente creatore</label>
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
  <?php if (isset($messaggio_successo)) : ?>
    <script>
        // Mostra un'alert con il messaggio di successo
        alert("<?= $messaggio_successo ?>"); 
        // Dopo il click sul bottone, reindirizza al login
        window.location.href = "/login"; 
    </script>
  <?php endif; ?>
  <!--script javascript per check validità campi lato client-->
  <script>
    document.addEventListener("DOMContentLoaded", function(){
      //imposto al campo input dell'anno di nascita un valore massimo dinamico, in modo che l'utente sia maggiorenne
      let oggi = new Date();
      let annoMinimo = oggi.getFullYear() - 18;
      document.getElementById("anno-nascita").setAttribute("max",annoMinimo);

      let form = document.querySelector("form");
      form.addEventListener("submit",function(event){
        //leggo i valori presi in input
        let password = document.getElementById("password").value;
        let confermaPassword = document.getElementById("conferma-password").value;
        let erroriDiv = document.getElementById("errori");
        //pulisco errori precedenti
        erroriDiv.innerHTML = "";

        //se le due password sono diverse gestisco l'errore
        if(password !== confermaPassword){
          //blocca l'invio del form
          event.preventDefault();
          //stampo l'errore 
          let errore = document.createElement("p");
          errore.classList.add("errori");
          errore.textContent = "Le password non coincidono.";
          erroriDiv.appendChild(errore);
        }
      })
    })
  </script>
</body>
</html>
