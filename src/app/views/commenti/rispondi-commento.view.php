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
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Rispondi</h3>
            <p>Inserisci una risposta al commento</p>
            <div class="commento">
                    <div class="intestazione">
                        <p><?= $commento['nickname']; ?> - <?= $commento['data']; ?></p>
                    </div>
                    <div class="corpo">
                        <p><?= $commento['commento']; ?></p>
                    </div>
                    <div class="risposta">
                        <textarea></textarea>
                    </div>
                </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
