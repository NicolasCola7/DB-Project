<?php
use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-foto.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
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
                        <input type='hidden' id='nFoto' value='<?= count($_SESSION['creazione-progetto']['foto']); ?>'>
                <?php elseif(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) === 'rewards'): ?>
                    <form id='submit-reward' action="/home/crea-progetto/rewards" method="POST" enctype='multipart/form-data'>
                        <input type='hidden' id='nRewards' value='<?= count($_SESSION['creazione-progetto']['rewards']); ?>'>
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
    <?= AlertManager::show(); ?>
</body>
<script src='/public/js/creazione-progetto/inserimento-foto-o-rewards.script.js'></script>

</html>