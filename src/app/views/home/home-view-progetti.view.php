<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        /* Stile generale */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background: #0077cc;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
            margin: 0;
        }

        header div {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header p {
            font-weight: bold;
            font-size: 16px;
        }

        header form input {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        header form input:hover {
            background: #cc0000;
        }

        /* Layout principale */
        .main {
            display: flex;
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1e1e2d;
            color: white;
            padding: 20px;
            min-height: 100vh;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #f8f9fa;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .sidebar a:hover {
            background: #0077cc;
            color: white;
            transform: scale(1.05);
        }

        /* Contenuto principale */
        .contenutoMain {
            flex: 1;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
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


        /* Footer */
        footer {
            background: #0077cc;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h2>BOSTARTER</h2>
        </div>
        <div id='info'>
            <img src="/icona-profilo" alt='icona profilo'>
            <p><?php echo($_SESSION['utente']['nickname']) ?></p>
            <form action='/logout' method='POST'>
                <input type="submit" value='Logout'>
            </form>
        </div>
    </header>
    
    <div class="main">
        <div class="sidebar">
            <ul>
                <li><a href="/home/visualizza-progetti-controller">Visualizza progetti disponibili</a></li>
                <li><a href="/home/le-mie-skill">Le mie skill</a></li>
                <?php if ($_SESSION['utente']['creatore']) : ?>
                    <li><a href="">Crea un nuovo progetto</a></li> 
                <?php endif; ?>
                <?php if ($_SESSION['utente']['admin']) : ?>
                    <li><a href="">Crea nuove skills</a></li> 
                <?php endif; ?>
                <?php if ($_SESSION['utente']['creatore']) : ?>
                    <li><a href="">Inserisci le rewards</a></li> 
                <?php endif; ?>
                <?php if ($_SESSION['utente']['creatore']) : ?>
                    <li><a href="">Visualizza i miei progetti</a></li>
                <?php endif; ?>
                <li><a href="">Visualizza statistiche</a></li>
                <?php if ($_SESSION['utente']['creatore']) : ?>
                    <li><a href="">Inserisci profilo</a></li>
                <?php endif; ?>
            </ul>
        </div>
        
        <div class="contenutoMain">
            <?php if(!empty($_SESSION['utente']['progetti']) && is_array($_SESSION['utente']['progetti'])): ?>
                <h3>Ecco i progetti disponibili</h3>
                <div class="grid">
                    <?php foreach ($_SESSION['utente']['progetti'] as $project): ?>
                        <a href="/home/info-progetto-controller">
                            <div class="card">
                                <div class="img">
                                    <img src="" alt="Foto del progetto">
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
    
    <footer>
        <p>BOSTARTER - Copyright &copy;, 2025</p>
    </footer>
</body>
</html>