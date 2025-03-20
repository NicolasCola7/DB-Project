<!DOCTYPE html>
<html>
<head>
    <title>Commenta Progetto</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/commenti/inserisci-commento.style.css'>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Commenta il progetto <span> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </span></h3>

            <section>
                <form action='/home/progetti/<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?>/commenti' method='POST'>
                    <div class='container'>
                        <label for='testo'>Testo del commento</label>
                        <textarea name='testo' id='testo' required placeholder='Inserisci il testo del commento...'></textarea>
                    </div>
                    <div class='container'>
                        <button type='submit'>Invia Commento</button>
                    </div>
                </form>
            </section>
            
            <div id="errori">
                <?php if (isset($errori['testo'])) : ?>
                    <p> <?= $errori['testo'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>

            <div id='successo'>
                <?php if (isset($successo)) : ?>
                    <script>
                        alert("Progetto commentato con successo");
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>

</body>

</html>