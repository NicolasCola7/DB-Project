<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Creazione progetto</title>
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

        .radio-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }

        input[type="radio"] {
            width: auto;
            margin-right: 5px;
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
            <h3>Crea un nuovo progetto</h3>

            <section>
                <form action="/home/crea-progetto/informazioni-base" method="POST">
                    
                    <div class="container">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="nome" required>
                    </div>
                    
                    <div class="container">
                        <label for="data-limite">Data limite</label>
                        <input type="date" id="data-limite" name="data-limite" required>
                    </div>
                    
                    <div class="container">
                        <label for="descrizione">Descrizione</label>
                        <textarea id="descrizione" name="descrizione" rows="4" placeholder="descrizione" required></textarea>
                    </div>
                    
                    <div class="container">
                        <label for="budget">Budget (€)</label>
                        <input type="number" id="budget" name="budget" placeholder="budget" required>
                    </div>
                    
                    <div class="container radio-group">
                        <input type="radio" id="hardware" name="tipo" value="hardware" checked>
                        <label for="hardware">Hardware</label>
                        
                        <input type="radio" id="software" name="tipo" value="software">
                        <label for="software">Software</label>
                    </div>

                    <div id="errori">
                        <?php if (isset($errori['nome'])) : ?>
                            <p><?= $errori['nome'] ?></p>
                        <?php endif; ?>

                        <?php if (isset($errori['data-limite'])) : ?>
                            <p><?= $errori['data-limite'] ?></p>
                        <?php endif; ?>

                        <?php if (isset($errori['descrizione'])) : ?>
                            <p><?= $errori['descrizione'] ?></p>
                        <?php endif; ?>

                        <?php if (isset($errori['budget'])) : ?>
                            <p><?= $errori['budget'] ?></p>
                        <?php endif; ?>

                        <?php if (isset($errori['procedura'])) : ?>
                            <p><?= $errori['procedura'] ?></p>
                        <?php endif; ?>

                    </div>


                    <button type="submit">Prosegui</button>
                </form>
            </section>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>

</body>
</html>
