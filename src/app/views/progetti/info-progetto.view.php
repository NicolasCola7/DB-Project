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

        .infoContainer, .immaginiContainerWrapper, .rewardsContainerWrapper,
.contenitoreProfili, .contenitoreCommenti, .componentiContainer {
    padding: 20px;
    border-radius: 10px;
    width: 70%;
    margin-bottom: 25px;
    background-color: white;
    border: 1px solid black;
}

        /* Tabelle */
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

        /* Card container per immagini e rewards */
        .immaginiContainerWrapper, .rewardsContainerWrapper {
            padding: 20px;
            border-radius: 10px;
            width: 70%;
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }

        .immaginiContainerWrapper h4, .rewardsContainerWrapper h4 , .infoContainer h4,
        .contenitoreCommenti h4, .contenitoreProfili h4{
            text-align: left;
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #333;
        }

        /* Grid per immagini e rewards */
        .immaginiContainer, .rewardsContainer {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            justify-content: left;
            max-width: 100%;
        }

        /* Imposta un massimo di 3 colonne */
        @media (min-width: 900px) {
            .immaginiContainer, .rewardsContainer {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Stile delle card delle immagini */
        .immaginiContainer div, .rewardsContainer div{
            display: flex;
            flex-direction: column;
            align-items: left;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-width: 200px; /* Impedisce che diventino troppo piccole */
        }

        /* Stile per le immagini */
        .immaginiContainer img, .rewardsContainer img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Stile per la descrizione sotto le immagini */
        .immaginiContainer p, .rewardsContainer p{
            text-align: center;
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
        }
        a{
            text-decoration: none;
        }
        a:hover{
            text-decoration: underline;
        }

        .form-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
        }
        .form-group label {
            width: 120px;
            display: inline-block;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            flex: 1;
            min-width: 250px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 80px;
        }
        .btn-container {
            text-align: right;
            margin-top: 20px;
        }
        .btn-aggiungi {
            background-color: #0078d4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-aggiungi:hover {
            background-color: #005a9e;
        }
        .aggiungi {
            background-color: #ffffff;
            border: 2px dashed #ddd;
            border-radius: 10px;
            width: 100%;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .aggiungi:hover {
            background-color: #f9f9f9;
            border-color: #4CAF50;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .aggiungi .plus-icon {
            background-color: #4CAF50;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            margin-right: 10px;
        }

        .aggiungi p {
            margin: 0;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            font-weight: bold;
            color: #4CAF50;
        }

        .form-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
        }
        .form-group label {
            width: 120px;
            display: inline-block;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            flex: 1;
            min-width: 250px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 80px;
        }
        .btn-container {
            text-align: right;
            margin-top: 20px;
        }
        .btn-aggiungi {
            background-color: #0078d4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-aggiungi:hover {
            background-color: #005a9e;
        }
        .aggiungi {
            background-color: #ffffff;
            border: 2px dashed #ddd;
            border-radius: 10px;
            width: 100%;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .aggiungi:hover {
            background-color: #f9f9f9;
            border-color: #4CAF50;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .aggiungi .plus-icon {
            background-color: #4CAF50;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            margin-right: 10px;
        }

        .aggiungi p {
            margin: 0;
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            font-weight: bold;
            color: #4CAF50;
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
            <div class='immaginiContainerWrapper'>
                <h4> Immagini del progetto </h4>
                <div class='immaginiContainer'>
                    <?php foreach($progetto['foto'] as $foto): ?>
                        <div>
                            <img src="../../../<?= urldecode($foto['urlImmagine']); ?>">
                            <p> <?= $foto['descrizione']; ?> </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                    <div class="aggiungi" onclick="aggiungiFoto()">
                        <div class="plus-icon">+</div>
                        <p>Aggiungi Nuova Foto</p>
                    </div>  
                <?php endif; ?>
            </div>

            <div class='rewardsContainerWrapper'>
                <h4> Rewards del progetto </h4>
                <div class='rewardsContainer'>
                    <?php foreach($progetto['rewards'] as $reward): ?>
                        <div>
                            <img src="../../../<?= $reward['urlFoto']; ?>" alt="Reward">
                            <p> <?= $reward['descr']; ?> </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                        <div class="aggiungi" onclick="aggiungiReward()">
                            <div class="plus-icon">+</div>
                            <p>Aggiungi Nuova Reward</p>
                        </div>  
                <?php endif; ?>
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
                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                        <div class="aggiungi" onclick="aggiungiComponente()">
                            <div class="plus-icon">+</div>
                            <p>Aggiungi Nuova Componente</p>
                        </div>  
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class='contenitoreProfili'>
                    <h4> Profili richiesti </h4>
                    <a href='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['nome']) ?>/profili'>
                        Profili richiesti per questo progetto
                    </a>
                </div>
            <?php endif; ?>
            <div class='contenitoreCommenti'>
                <h4> Commenti pubblicati </h4>
                <a href='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['nome']) ?>/commenti'>
                    Visualizza i commenti pubblicati per questo progetto
                </a>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>
    const nomeProgetto = '<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>';
    
     function aggiungiComponente() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-componente`;
    }

    function aggiungiReward() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-reward`;
    }

    function aggiungiFoto() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-foto`;
    }
</script>

</html>