<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/statistiche/statistiche.style.css'>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>

    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>

        <div class="contenutoMain">
            <h3>Statistiche</h3>

            <div class="statistiche">
                <h3>Classifica Creatori per Affidabilità</h3>
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
                                    <td> <?= htmlspecialchars($creatore['nickname']); ?> </td>
                                    <td> <?= htmlspecialchars($creatore['affidabilita']); ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr colspan='2'>
                                <td> Non sono presenti sufficienti dati per la seguente classifica </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            
                <h3>Progetti Vicini al Completamento</h3>
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
                                    <td> <?= htmlspecialchars($progetto['nome']); ?> </td>
                                    <td> <?= htmlspecialchars($progetto['budget_mancante']); ?> </td>
                                    <td> <?= htmlspecialchars($progetto['budget_avvio']); ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr colspan='3'>
                                <td> Non sono presenti sufficienti dati per la seguente classifica </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <h3>Classifica Finanziatori</h3>
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
                                    <td> <?= htmlspecialchars($finanziatore['nickname']); ?> </td>
                                    <td> <?= htmlspecialchars($finanziatore['totale_finanziamento']); ?> </td>
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