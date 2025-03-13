<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        html, body {
            /* Assicura che il body occupi tutta l'altezza dello schermo */
            height: 100vh; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            /* Evita lo scrolling dell'intera pagina */
            overflow: hidden; 
        }  

        .main {
            display: flex;
            /* Occupa tutto lo spazio disponibile */
            flex-grow: 1; 
            /* Evita scrolling non necessario */
            overflow: hidden; 
        }

        .contenutoMain {
            flex-grow: 1;
            max-height: 100%;
            /* Abilita lo scroll solo su questo contenitore */
            overflow-y: auto; 
            padding: 20px;
            margin: 10px;
        }

        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .grid{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2%;
            justify-content: center;
        }
        .card {
            width: 270px;
            height: 165px; /* Altezza ridotta senza bottoni */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            text-align: center;
            background: #fff;
            margin-top: 15px;
            position: relative;
            transition: height 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            height: 200px;
            transform: scale(1.05);
        }

        .card .img {
            width: 100%;
            height: 130px;
            background: #f0f0f0;
            position: relative;
        }

        .card .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #stato {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 12px;
        }

        .stato-aperto {
            background: #28a745; /* Verde */
        }

        .stato-chiuso {
            background: #dc3545; /* Rosso */
        }

        .card .info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            font-size: 13px;
            font-weight: bold;
            color: #333;
            background-color: #f1f1f1;
            border-top: 1px solid #ddd;
        }

        .card .info div {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .card .info div:hover .tooltip {
            opacity: 1;
        }

        .card .azioni {
            display: flex;
            width: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .card:hover .azioni {
            opacity: 1;
            visibility: visible;
        }


        .card .azioni form {
            flex: 1; /* Permette ai form di occupare tutto lo spazio disponibile */
            display: flex;
        }

        .card .azioni button {
            flex: 1; /* Assicura che i bottoni si espandano equamente */
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            text-align: center;
        }

        .card .azioni button:hover {
            background: #0056b3;
            color: white;
        }

        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <?php if(!empty($_SESSION['utente']['progetti']) && is_array($_SESSION['utente']['progetti'])): ?>
                <h3>Ecco i progetti disponibili</h3>
                <div class="grid">
                    <?php foreach ($_SESSION['utente']['progetti'] as $project): ?>
                        <a href="/home/info-progetto?nome=<?= urlencode($project['NomeProgetto']) ?>">
                            <div class="card">
                                <div class="img">
                                    <img src="<?= '../'.htmlspecialchars($project['urlImmagine'])?>" alt="Foto del progetto" >
                                </div>
                                <div class="info">
                                    <div id="nomeProgetto">
                                        <p><?= htmlspecialchars($project['NomeProgetto'])?>
                                    </div> 
                                    <div id="nickname">
                                        <p><?= htmlspecialchars($project['nickname'])?>
                                    </div> 
                                    <div id="stato" class="<?= $project['stato'] === 'aperto' ? 'stato-aperto' : 'stato-chiuso' ?>">
                                        <p><?= htmlspecialchars($project['stato']) ?></p>
                                    </div>

                                </div>
                                <div class="azioni">
                                    <form action='/home/progetti/<?= urlencode($project['NomeProgetto']); ?>/commenti' method='GET'>
                                        <button type="submit">Commenta</button>
                                    </form>
                                    <?php if($project['stato'] === 'aperto'): ?>
                                        <form action='/home/progetti/<?= urlencode($project['NomeProgetto']); ?>/finanziamenti' method='GET'>
                                            <button type="submit">Finanzia</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h3>Nessun progetto disponibile.</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>