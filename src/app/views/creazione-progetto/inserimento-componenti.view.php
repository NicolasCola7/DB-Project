<?php
// se non si sono inserite le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}
use core\AlertManager;
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

        #btnProsegui{
            width: 135px;
        }

        #successo {
            color: green;
        }

        #container-tabella {
            max-width: 800px;
        }

        table {
            flex: 1;
            margin-top: 10px;
            margin-bottom: 20px;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #aaa;
        }

        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: left;
        }

        th {
            background-color: #0077cc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d8eaff;
        }

    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Inserimento componenti</h3>

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
                        <div class='container-bottoni'>
                            <button id='aggiungi' type='submit'>Aggiungi componente</button>
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

                <div class='container-bottoni2'>
                    <button id="btnProsegui" onclick='prosegui()'>Prosegui</button>
                </div>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
<script>

    function prosegui() {
        let nComponenti = <?php echo count($_SESSION["creazione-progetto"]["componenti"]); ?>;
        if(nComponenti > 0) {
            <?php $_SESSION["creazione-progetto"]["step2"] = true; ?>
            window.location.href = "/home/crea-progetto/foto";
        } else {
            Swal.fire({
                title: "Attenzione!",
                text: "Devi inserire almeno una componente.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    } 
</script>
</html>