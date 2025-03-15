<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiche</title>
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
            color: #0077cc;
            justify-content: center;
            padding-bottom: 2%;
            border-bottom: 2px solid #0077cc;
        }

        .statistiche {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .statistica {
            display: grid;
            grid-template-columns: minmax(120px, 1fr) 1fr auto;
            gap: 15px;
            align-items: center;
            padding: 5%;
            border-bottom: 1px solid #0077cc;
            color: #0077cc;
        }

        .statistiche > h2 {
            text-align: center;
            color: #0077cc;
            margin-top: 20px;
        }

        table {
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


        .errore {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>

    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>

        <div class="contenutoMain">
            <header>
                <h2>Statistiche</h2>
            </header>

            <div class="statistiche">
                <h2>Classifica Creatori per Affidabilità</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nickname</th>
                            <th>Affidabilità</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($classificaCreatori)): ?>
                            <?php foreach($classificaCreatori as $creatore): ?>
                                <tr>
                                    <td> <?= $creatore['nickname']; ?> </td>
                                    <td> <?= $creatore['affidabilita']; ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr colspan='2'>
                                <td> Non sono presenti sufficienti dati per la seguente classifica </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            
                <h2>Progetti Vicini al Completamento</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome Progetto</th>
                            <th>Budget Mancante (€)</th>
                            <th>Budget Avvio (€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($progettiVicini)): ?>
                            <?php foreach($progettiVicini as $progetto): ?>
                                <tr>
                                    <td> <?= $progetto['nome']; ?> </td>
                                    <td> <?= $progetto['budget_mancante']; ?> </td>
                                    <td> <?= $progetto['budget_avvio']; ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr colspan='3'>
                                <td> Non sono presenti sufficienti dati per la seguente classifica </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <h2>Classifica Finanziatori</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nickname</th>
                            <th>Totale Finanziamenti (€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($classificaFinanziatori)): ?>
                            <?php foreach($classificaFinanziatori as $finanziatore): ?>
                                <tr>
                                    <td> <?= $finanziatore['nickname']; ?> </td>
                                    <td> <?= $finanziatore['totale_finanziamento']; ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr colspan='2'>
                                <td> Non sono presenti sufficienti dati per la seguente classifica </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>