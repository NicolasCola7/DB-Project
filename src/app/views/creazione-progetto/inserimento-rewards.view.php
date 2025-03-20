<?php

//se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}
use core\AlertManager;

//se l'utente, a seconda del tipo di progetto, non ha inserito le foto lo redirigo alle pagine apposite 
if(!$_SESSION['creazione-progetto']['step3']) {
    header('location: /home/crea-progetto/foto');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-foto.style.css'>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Inserimento reward</h3>

            <section>
                <form action="/home/crea-progetto/rewards" method="POST" enctype='multipart/form-data'>
                    <div class='container'>
                        <label for='foto'> Immagine </label>
                        <?php require view('/creazione-progetto/upload.view.php'); ?>
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
            <div class='container'>
                <button onclick="prosegui()">Prosegui</button>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function prosegui() {
        const rewards =  <?= count($_SESSION['creazione-progetto']['rewards']); ?>;
        if(rewards < 1) {
            Swal.fire({
                title: "Errore",
                text: "Devi inserire almeno una reward!",
                icon: "error",
                confirmButtonText: "OK"
            });
        } else {
            <?php $_SESSION["creazione-progetto"]["step4"] = true; ?>
            window.location.href = '/home/crea-progetto/conferma-dati';
        }
    }
</script>
</html>