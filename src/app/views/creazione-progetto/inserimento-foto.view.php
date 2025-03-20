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

use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento componenti</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-foto.style.css'>
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
    <?= AlertManager::show($errori ?? []) ?>
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