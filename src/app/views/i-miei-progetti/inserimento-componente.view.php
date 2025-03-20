
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/i-miei-progetti/inserimento-componente.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            
            <h3> Inserimento componente </h2>

            <section>
                <div>
                    <form id='form-componenti' action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/componenti' method="POST">
                        <div class="container">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" placeholder="nome" required>
                        </div>
                        <div class="container">
                            <label for="descrizione">Descrizione</label>
                            <textarea id="descrizione" name="descrizione" rows="4" placeholder="descrizione" required></textarea>
                        </div>
                        <div class="container">
                            <label for="quantità">Quantità</label>
                            <input type="number" id="quantità" name="quantita" placeholder="quantità" min='1' required>
                         </div>
                        <div class="container">
                            <label for="prezzo">Prezzo</label>
                            <input type="number" id="prezzo" name="prezzo" placeholder="prezzo" min='1' required>
                        </div>
                        <div class='container-bottoni'>
                            <button id='aggiungi' type='submit'> Aggiungi </button>
                        </div>
                    </form>
                </div>
                
                <div id="errori">
                    <?php if (isset($errori['nome'])) : ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['nome']; ?>",
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

                    <?php if (isset($errori['quantita'])) : ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['quantita']; ?>",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        </script>
                    <?php endif; ?>

                    <?php if (isset($errori['prezzo'])) : ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['prezzo']; ?>",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        </script>
                    <?php endif; ?>
                    <?php if (isset($errori['procedura'])) : ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    title: "Errore di inserimento!",
                                    text: "<?php echo $errori['procedura']; ?>",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        </script>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>