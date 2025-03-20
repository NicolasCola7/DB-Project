<!DOCTYPE html>
<html>
<head>
    <title>Insermento reward</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/i-miei-progetti/inserimento-foto.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3> Inserimento reward </h3>

            <section>
                <form action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/rewards' method="POST" enctype='multipart/form-data'>
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

            <div id='errori'>
                <?php if (isset($errori['estensione'])) : ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "Errore di inserimento!",
                                text: "<?php echo $errori['estensione']; ?>",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($errori['descrizione'])) : ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "Errore di inserimento!",
                                text: "<?php echo $errori['descrizione']; ?>",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($errori['dimensione'])) : ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "Errore di inserimento!",
                                text: "<?php echo $errori['dimensione']; ?>",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($errori['procedure'])) : ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "Errore di inserimento!",
                                text: "<?php echo $errori['procedure']; ?>",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

</html>