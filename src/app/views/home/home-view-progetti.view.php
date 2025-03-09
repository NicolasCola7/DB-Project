<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        .contenutoMain {
            margin: 20px;
        }
        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .grid{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 300px;
            height: 270px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            text-align: center;
            background: #fff;
            margin-top: 15px;
            position: relative;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card .img {
            width: 100%;
            height: 150px;
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
            padding: 12px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            border-top: 1px solid #ddd;
        }

        .card .info div {
            flex: 1;
            text-align: center;
        }

        .card .azioni {
            display: flex;
            flex-direction: column;
            border-top: 1px solid #ddd;
            background: #f9f9f9;
        }

        .card .azioni button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 0;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }

        .card .azioni button:hover {
            background: #0056b3;
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
                                    <img src="<?= !empty($project['urlImmagine']) ? '../'.htmlspecialchars($project['urlImmagine']) : '/public/immagini/default.avif' ?>" alt="Foto del progetto" >
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
                                    <form action='' method='POST'>
                                        <button type="submit">Commenta</button>
                                    </form>
                                    <form action='' method='POST'>
                                        <button type="submit">Finanzia</button>
                                    </form>
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