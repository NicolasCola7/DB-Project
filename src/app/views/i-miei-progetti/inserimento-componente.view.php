
<!DOCTYPE html>
<html>
<head>
    <title>Insermento componente</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


        section > div:first-child {
            display: flex;
            flex-direction: row;
            gap: 5%;
            justify-content: space-between;
        }

        section form {
            flex: 2;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px 0;
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

        .container-bottoni{
            text-align: left;
        }
        .container-bottoni2{
            text-align: center;
        }

        .container-bottoni button{
            width: 180px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

    </style>
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