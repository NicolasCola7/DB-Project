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
            height: 250px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            text-align: center;
            background: #fff;
            margin-top: 15px;
        }

        .card .img {
            width: 100%;
            height: 150px;
            background: #f0f0f0;
        }

        .card .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card .info {
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .card .azioni {
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }

        .card .azioni button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
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
                                    <p><?= htmlspecialchars($project['NomeProgetto'])?>, 
                                    <?= htmlspecialchars($project['NomeCreatore'])?> <?= htmlspecialchars($project['cognome'])?>, 
                                    <?= htmlspecialchars($project['stato'])?></p>
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