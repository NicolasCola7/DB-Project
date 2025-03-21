<?php

//se ci si trova nella pagina di caricamento delle foto
if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) === 'inserimento-foto') {
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

} elseif(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) === 'inserimento-rewards') { //se ci si trova nella pagina di caricamento delle rewards
    //se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
    if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
        header('location: /home/crea-progetto/informazioni-base');
        exit();
    }

    //se l'utente non ha inserito le foto lo redirigo alle pagine apposite 
    if(!$_SESSION['creazione-progetto']['step3']) {
        header('location: /home/crea-progetto/foto');
        exit();
    }
}


use core\AlertManager;
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
        <?php 
            $url_parts = explode('/', $_SERVER['REQUEST_URI']);

            if( 
                (urldecode($url_parts[3]) === 'foto') || 
                (isset($url_parts[4]) && urldecode($url_parts[4]) === 'aggiungi-foto')
            ): 
        ?>
            <h3>Inserimento foto</h3>
        <?php else: ?>
            <h3> Inserimento reward </h3>
        <?php endif; ?>

            <section>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) === 'foto'): ?>
                    <form id='submit-foto' action="/home/crea-progetto/foto" method="POST" enctype='multipart/form-data'>
                <?php elseif(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) === 'rewards'): ?>
                    <form id='submit-reward' action="/home/crea-progetto/rewards" method="POST" enctype='multipart/form-data'>
                <?php else: ?>
                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[4]) === 'aggiungi-reward'): ?>
                        <form action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/rewards' method="POST" enctype='multipart/form-data'>
                    <?php else: ?>
                        <form action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/foto' method="POST" enctype='multipart/form-data'>
                    <?php endif; ?>
                <?php endif; ?>

                    <div class='container'>
                        <label for='foto'> Immagine </label>
                        <div class="file-drop-area">
                            <span class="fake-btn">Scegli un file</span>
                            <span class="file-msg">o alternativamente trascinane uno qui</span>
                            <input class="file-input" name='foto' type="file" accept="image/png, image/jpeg, image/jpg, image/webp, image/avif" required>
                        </div>
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
            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2] === 'crea-progetto')): ?>
                <div class='container'>
                    <button onclick="<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) === 'foto' ? "proseguiARewards()" : "proseguiAConferma()" ?>">
                        Prosegui
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const fileDropArea = document.querySelector('.file-drop-area');
    const fileInput = fileDropArea.querySelector('.file-input');
    const fileMsg = fileDropArea.querySelector('.file-msg');
    
    // Evidenzia la drag area quando un file è trascinato sopra essa
    ['dragenter', 'dragover'].forEach(event => {
        fileDropArea.addEventListener(event, e => {
        e.preventDefault();
        highlight();
        });
    });
    
    ['dragleave', 'drop'].forEach(event => {
        fileDropArea.addEventListener(event, e => {
        e.preventDefault();
        unhighlight();
        });
    });
    
    // Gestione file droppato
    fileDropArea.addEventListener('drop', handleDrop);
    
    // Festione file inserito
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileMsg.textContent = this.files[0].name;
        }
    });
    
    function highlight() {
        fileDropArea.classList.add('is-active');
    }
    
    function unhighlight() {
        fileDropArea.classList.remove('is-active');
    }
    
    function handleDrop(e) {
        e.preventDefault();
        const file = e.dataTransfer.files[0]; // Ottengo solo il primo file
        
        if (file) {
        fileMsg.textContent = file.name;
        
        // Aggiorno il file di input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        
        // Triggera un change event
        const event = new Event('change');
        fileInput.dispatchEvent(event);
        }
    }

    function proseguiARewards() {
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
    function proseguiAConferma() {
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