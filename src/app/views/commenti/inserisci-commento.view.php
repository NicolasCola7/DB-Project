<!DOCTYPE html>
<html>
<head>
    <title>Commenta Progetto</title>
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
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
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
        }
        
        .container {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;

        }
        
        textarea {
            width: 100%;
            height: 150px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        textarea:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 5px rgba(0, 119, 204, 0.2);
        }
        
        button {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #005fa3;
        }
    </style>
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