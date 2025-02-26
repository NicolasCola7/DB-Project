<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiche</title>
    <style>
        .contenutoMain {
            margin: 20px 10%;
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
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #0077cc;
            color: white;
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
                <?php if (!empty($classificaCreatori)) : ?>
                    <table>
                        <tr>
                            <th>Nickname</th>
                            <th>Affidabilità</th>
                        </tr>
                        <?php foreach ($classificaCreatori as $creatore) : ?>
                            <tr>
                                <td><?= htmlspecialchars($creatore['nickname']) ?></td>
                                <td><?= htmlspecialchars($creatore['affidabilita']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <p class="errore">Nessun creatore disponibile.</p>
                <?php endif; ?>

                <h2>Progetti Vicini al Completamento</h2>
                <?php if (!empty($progettiVicini)) : ?>
                    <table>
                        <tr>
                            <th>Nome Progetto</th>
                            <th>Budget Mancante (€)</th>
                        </tr>
                        <?php foreach ($progettiVicini as $progetto) : ?>
                            <tr>
                                <td><?= htmlspecialchars($progetto['nome']) ?></td>
                                <td><?= number_format($progetto['budget_mancante']) ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <p class="errore">Nessun progetto vicino al completamento.</p>
                <?php endif; ?>

                <h2>Classifica Finanziatori</h2>
                <?php if (!empty($classificaFinanziatori)) : ?>
                    <table>
                        <tr>
                            <th>Nickname</th>
                            <th>Totale Finanziamenti (€)</th>
                        </tr>
                        <?php foreach ($classificaFinanziatori as $finanziatore) : ?>
                            <tr>
                                <td><?= htmlspecialchars($finanziatore['nickname']) ?></td>
                                <td><?= number_format($finanziatore['totale_finanziamento']) ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <p class="errore">Nessun finanziatore registrato.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>