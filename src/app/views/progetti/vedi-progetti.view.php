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
        }

        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .grid{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 3%;
            justify-content: center;
        }
        .card {
            width: 270px;
            height: 185px; /* Altezza ridotta senza bottoni */
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
            height: 220px;
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

        .progress{
            background-color: #f1f1f1;
        }

        progress {
            width: 80%;
            height: 10px;
            border-radius: 10px;
            margin: 5px 0;
        }
        
        progress::-webkit-progress-bar {
            background-color: #ddd;
            border-radius: 10px;
        }
        
        progress::-webkit-progress-value {
            background-color: #4caf50;
            border-radius: 10px;
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
            <?php if(!empty($progetti) && is_array($progetti)): ?>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti'): ?>
                    <h3>Progetti disponibili </h3>
                <?php else: ?>
                    <h3> I miei progetti </h3>
                <?php endif; ?>
                <div class="grid">
                    <?php foreach ($progetti as $progetto): ?>
                        <?php if($progetto['nickname'] === $_SESSION['utente']['nickname']): ?>
                            <a href="/home/i-miei-progetti/<?= urlencode($progetto['NomeProgetto']) ?>">
                        <? else: ?>
                            <a href="/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']) ?>">
                        <?php endif; ?>
                            <div class="card">
                                <div class="img">
                                    <img src="<?= '../'.htmlspecialchars($progetto['urlImmagine'])?>" alt="Foto del progetto" >
                                </div>
                                <div class="info">
                                    <div id="nomeProgetto">
                                        <p><?= htmlspecialchars($progetto['NomeProgetto'])?>
                                    </div> 
                                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti'): ?>
                                        <div id='nomeUtente'>
                                            <p><?= htmlspecialchars($progetto['nickname'])?>
                                        </div>
                                    <?php endif; ?>
                                    <div id="stato" class="<?= $progetto['stato'] === 'aperto' ? 'stato-aperto' : 'stato-chiuso' ?>">
                                        <p><?= htmlspecialchars($progetto['stato']) ?></p>
                                    </div>  
                                </div>
                                <div class="progress">
                                    <progress id="myProgress" value="50" max="100"></progress>
                                </div>
                                <div class="azioni">
                                    <form action='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']); ?>/commenta' method='GET'>
                                        <button type="submit">Commenta</button>
                                    </form>
                                    <?php if($progetto['stato'] === 'aperto'): ?>
                                        <form action='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']); ?>/finanzia' method='GET'>
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