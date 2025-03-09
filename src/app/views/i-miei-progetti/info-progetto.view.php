<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        .contenutoMain {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .contenutoMain p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
            display: flex;
            flex-direction: column;
        }

        .descrizione-container {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .descrizione-container textarea {
            flex: 1;
            resize: vertical;
            height: 50px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #555;
        }
        .infoContainer, .componentiContainer, .contenitoreProfili{
            padding: 10px;
            border: 1px solid #555;
            border-radius: 10px;
            width: 70%;
            margin-bottom: 25px;
        }
        .componentiContainer table {
            margin-top: 10px;
            border: 1px solid black;
            width: 100%;
        }
        .componentiContainer table tr th, .componentiContainer table tr td{
            border: 1px solid black;
            padding: 5px;
        }
        .componentiContainer table th{
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Dettagli del progetto <?= $progetto['nome']; ?> </h3>
            <div class='infoContainer'>
                <h4> Informazioni </h4>
                <p> Data di inserimento: <?= $progetto['data_inserimento']; ?> </p>
                <p> Data di fine: <?= $progetto['data_limite']; ?> </p>
                <div class='descrizione-container'>
                    <p> Descrizione: </p>
                    <textarea readonly> <?= $progetto['descrizione']; ?> </textarea>
                </div>
                <p> Stato: <?= $progetto['stato'] ?> </p>
                <p> Tipo: <?= $progetto['tipo'] ?> </p>
                <p> Budget d'avvio: <?= $progetto['budget'] ?> EUR </p>
                <p> Finaziamenti ricevuti: <?= $progetto['finanziamenti'] ?> EUR </p>
            </div>
            <?php if($progetto['tipo'] === 'Hardware'): ?>
                <div class='componentiContainer'>
                    <h4> Componenti </h4>
                    <table>
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> Prezzo </th>
                                <th> Descrizione </th>
                                <th> Quantità </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($progetto['componenti'] as $componente): ?>
                                <tr>
                                    <td> <?= $componente['nome']; ?> </td>
                                    <td> <?= $componente['prezzo']; ?> </td>
                                    <td> <?= $componente['descr']; ?> </td>
                                    <td> <?= $componente['quantita']; ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class='contenitoreProfili'>
                    <h4> Profili richiesti </h4>
                    <a href='/home/i-miei-progetti/<?= $progetto['nome'] ?>/profili'>
                        Profili richiesti per questo progetto
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

</html>