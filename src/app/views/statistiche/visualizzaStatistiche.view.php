<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
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
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

    <h2>Classifica Creatori per Affidabilità</h2>
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

    <h2>Progetti Vicini al Completamento</h2>
    <table>
        <tr>
            <th>Nome Progetto</th>
            <th>Budget Mancante (€)</th>
        </tr>
        <?php foreach ($progettiVicini as $progetto) : ?>
            <tr>
                <td><?= htmlspecialchars($progetto['nome']) ?></td>
                <td><?= htmlspecialchars($progetto['budget_mancante']) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Classifica Finanziatori</h2>
    <table>
        <tr>
            <th>Nickname</th>
            <th>Totale Finanziamenti (€)</th>
        </tr>
        <?php foreach ($classificaFinanziatori as $finanziatore) : ?>
            <tr>
                <td><?= htmlspecialchars($finanziatore['nickname']) ?></td>
                <td><?= htmlspecialchars($finanziatore['totale_finanziamento']) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>