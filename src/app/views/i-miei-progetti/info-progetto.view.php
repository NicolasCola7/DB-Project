<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
                    <a href='/home/i-miei-progetti/<?= urlencode($progetto['nome']) ?>/profili'>
                        Profili richiesti per questo progetto
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

</html>