
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
    <form action="/registrazione" method="POST">

      <?php require view('/autenticazione/registrazione-form-base.view.php'); ?>

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
