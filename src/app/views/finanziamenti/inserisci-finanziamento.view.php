<!DOCTYPE html>
<html>
<head>
    <title>Finanzia Progetto</title>
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
        
        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            background: white;
            color:  #0077cc;
            justify-content: center;
            padding-bottom: 2%;
            border-bottom: 2px solid   #0077cc;
        }

        section {
            display: flex;
            flex-direction: column;
            padding: 30px;
        }
        
        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
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
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        input:focus {
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
            <header>
               <h2>Finanzia il progetto ...</h2>
            </header>

            <section>
                <form action='/home/progetti/<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?>/finanziamenti' method='POST'>
                    <div class='container'>
                        <label for='importo'>Importo (€)</label>
                        <input type='number' name='importo' id='importo' required min='1'>
                    </div>
                    <div class='container'>
                        <button type='submit'>Invia Finanziamento</button>
                    </div>
                </form>
            </section>
            
            <div id="errori">
                <?php if (isset($errori['importo'])) : ?>
                    <p> <?= $errori['importo'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>

</body>

</html>