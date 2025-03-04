<?php

//se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}

//se l'utente, a seconda del tipo di progetto, non ha inserito componenti o profili lo redirigo alle pagine apposite 
if(!$_SESSION['creazione-progetto']['step2']) {
    if($_SESSION['creazione-progetto']['tipo'] === 'hardware')
        header('location: /home/crea-progetto/hardware/componenti');
    else
        header('location: /home/crea-progetto/software/profili');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento componenti</title>
    <style>

        .contenutoMain {
            margin: 20px;
        }

        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            justify-content: center;
            color: #0077cc;
            border-bottom: 2px solid #0077cc;
            padding-bottom: 1em;
            margin-bottom: 1em;
            background: #fff;
        }

        section {
            margin-top: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto; 
        }

        .container {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .bottoni {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #0077cc;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        #successo {
            color: green;
        }

    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
                <h2> Inserimento foto </h2>
            </header>

            <section>
                <form id='submit-foto' action="/home/crea-progetto/foto" method="POST" enctype='multipart/form-data'>
                    <div class='container'>
                        <label for='foto'> Scegli una foto </label>
                        <input type='file' name='foto' accept="image/png, image/jpeg, image/jpg" required>
                    </div>
                    
                    <div class='container'>
                        <label for='descrizione'> Descrizione </label>
                        <textarea name='descrizione' rows='4' required> </textarea>
                    </div>
                    
                    <div class='container'>
                        <button id='aggiungi' type='submit'> Aggiungi </button>
                    </div>
                </form>
            </section>

            <div id='errori'>
                <?php if (isset($errori['estensione'])) : ?>
                    <p><?= $errori['estensione'] ?></p>
                <?php endif; ?>

                <?php if (isset($errori['descrizione'])) : ?>
                    <p><?= $errori['descrizione'] ?></p>
                <?php endif; ?>

                <?php if (isset($errori['dimensione'])) : ?>
                    <p><?= $errori['dimensione'] ?></p>
                <?php endif; ?>

                <?php if (isset($errori['upload'])) : ?>
                    <p><?= $errori['upload'] ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['aggiunta-foto'])) : ?>
                    <?php if ($_SESSION['aggiunta-foto']) : ?>
                        <p id='successo'> Foto aggiunta con successo! </p>
                    <?php else :?>
                        <p> Foto già inserita!</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class='container'>
                <button onclick="prosegui()">Prosegui</button>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function prosegui() {
        const nFoto =  <?= count($_SESSION['creazione-progetto']['foto']); ?>;
        if(nFoto < 1) {
            alert("Devi inserire almeno una foto!");
        } else {
            <?php $_SESSION["creazione-progetto"]["step3"] = true; ?>
            window.location.href = '/home/crea-progetto/rewards';
        }
    }
</script>
</html>