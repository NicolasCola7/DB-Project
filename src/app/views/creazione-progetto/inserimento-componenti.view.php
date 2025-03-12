<?php
// se non si sono inserite le informazioni base lo redirigo alla pgina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento componenti</title>
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
            justify-content: center;
            color: #0077cc;
            border-bottom: 2px solid #0077cc;
            padding-bottom: 1em;
            margin-bottom: 1em;
            background: #fff;
        }

        section {
            margin-top: 20px;
        }

        section > div:first-child {
            display: flex;
            flex-direction: row;
            gap: 5%;
            justify-content: space-between;
        }

        form {
            flex: 2;
            max-width: 600px;
            margin: 0 auto; 
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

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        #successo {
            color: green;
        }

        #container-tabella {
            max-height: 350px;
            overflow-y: auto
        }

        table {
            flex: 1;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        thead {
            background-color: #0077cc;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
                <h2> Inserimento componenti </h2>
            </header>

            <section>
                <div>
                    <form id='form-componenti' action="/home/crea-progetto/hardware/componenti" method="POST">
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
                            <input type="number" id="quantità" name="quantità" placeholder="quantità" min='1' required>
                         </div>
                        <div class="container">
                            <label for="prezzo">Prezzo</label>
                            <input type="number" id="prezzo" name="prezzo" placeholder="prezzo" min='1' required>
                        </div>
                        <div class='container bottoni'>
                            <button id='aggiungi' type='submit'> Aggiungi </button>
                        </div>
                    </form>

                    <div id='container-tabella'>
                        <table>
                            <thead>
                                <tr>
                                    <th> Nome </th>
                                    <th> Descrizione </th>
                                    <th> Quantità </th>
                                    <th> Prezzo </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($_SESSION['creazione-progetto']['componenti']) > 0): ?>
                                    <?php foreach($_SESSION['creazione-progetto']['componenti'] as $componente): ?>
                                        <tr>
                                            <td> <?= $componente['nome']; ?> </td>
                                            <td> <?= $componente['descrizione']; ?> </td>
                                            <td> <?= $componente['quantità']; ?> </td>
                                            <td> <?= $componente['prezzo']; ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr> <td colspan='4'> Nessuna componente inserita  </td> </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div id="errori">
                    <?php if (isset($errori['nome'])) : ?>
                        <p><?= $errori['nome'] ?></p>
                    <?php endif; ?>

                    <?php if (isset($errori['descrizione'])) : ?>
                        <p><?= $errori['descrizione'] ?></p>
                    <?php endif; ?>

                    <?php if (isset($errori['quantità'])) : ?>
                        <p><?= $errori['quantità'] ?></p>
                    <?php endif; ?>

                    <?php if (isset($errori['prezzo'])) : ?>
                        <p><?= $errori['prezzo'] ?></p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['aggiunta-componente'])) : ?>
                        <?php if ($_SESSION['aggiunta-componente']) : ?>
                            <p id='successo'> Componente aggiunta con successo! </p>
                        <?php else :?>
                            <p> Componente già inserita!</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class='container bottoni'>
                    <button onclick='prosegui()'>Prosegui</button>
                </div>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>

    function prosegui() {
        let nComponenti = <?php echo count($_SESSION["creazione-progetto"]["componenti"]); ?>;
        if(nComponenti > 0) {
            <?php $_SESSION["creazione-progetto"]["step2"] = true; ?>
            window.location.href = "/home/crea-progetto/foto";
        } else {
            alert("Devi inserire almeno una componente!");
        }
    } 
</script>

</html>