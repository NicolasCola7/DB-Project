<!DOCTYPE html>
<html>
<head>
    <title>Insermento reward</title>
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

    </style>
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