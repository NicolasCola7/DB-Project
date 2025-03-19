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
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }    

        .main {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .contenutoMain {
            flex-grow: 1;
            max-height: 100%;
            overflow-y: auto;
            padding: 20px;
            margin: 10px;
        }

        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        section form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 25px 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
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
        .contenutoMain > .container{
            align-items: center;
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
            width: 135px;
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
            <h3>Inserimento foto</h3>

            <section>
                <form id='submit-foto' action="/home/crea-progetto/foto" method="POST" enctype='multipart/form-data'>
                    <div class='container'>
                        <label for='foto'> Immagine </label>
                        <?php require view('/creazione-progetto/upload.view.php'); ?>
                    </div>
                    
                    <div class='container'>
                        <label for='descrizione'> Descrizione </label>
                        <textarea name='descrizione' rows='4' required> </textarea>
                    </div>
                    
                    <div class='container'>
                        <button id='aggiungi' type='submit'>Aggiungi</button>
                    </div>
                </form>
            </section>
            <div class='container'>
                <button onclick="prosegui()">Prosegui</button>
            </div>
        </div>
    </div>
    <?php require view('/home/home-footer.view.php'); ?>
    <?php if (isset($errori) && !empty($errori)) : ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const errori = <?php echo json_encode($errori); ?>;
            let messaggi = "";
            for (const key in errori) {
                if (errori.hasOwnProperty(key)) {
                    messaggi += `${errori[key]}\n`;
                }
            }
            Swal.fire({
                title: "Attenzione!",
                text: messaggi.trim(),
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['aggiunta-foto'])) : ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                <?php if ($_SESSION['aggiunta-foto']) : ?>
                    Swal.fire({
                        title: "Successo!",
                        text: "Foto aggiunta con successo!",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                <?php else : ?>
                    Swal.fire({
                        title: "Attenzione!",
                        text: "Foto già inserita!",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                <?php endif; ?>
            });
        </script>
        <?php unset($_SESSION['aggiunta-foto']); ?>
    <?php endif; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function prosegui() {
        const nFoto =  <?= count($_SESSION['creazione-progetto']['foto']); ?>;
        if(nFoto < 1) {
            Swal.fire({
                title: "Attenzione!",
                text: "Devi inserire almeno una foto.",
                icon: "error",
                confirmButtonText: "OK"
            });
        } else {
            <?php $_SESSION["creazione-progetto"]["step3"] = true; ?>
            window.location.href = '/home/crea-progetto/rewards';
        }
    }
</script>
</html>