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
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .contenutoMain h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .commento {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            transition: transform 0.2s ease-in-out;
            background-color: #f9f9f9;
            border-left: 5px solid #007bff;
        }

        .intestazione {
            font-weight: bold;
            font-size: 14px;
            color: #555;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .corpo {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }
        
        .risposta {
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            padding-left: 20px;
            
            background-color: #f1f8e9;
        }

        .risposta form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .risposta textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.2s ease-in-out;
            border: none;
            background-color: #f1f8e9;
        }

        .risposta textarea:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(191, 255, 0, 0.3);
        }

        .risposta button {
            align-self: flex-start;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .risposta button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Rispondi al commento</h3>
            
            <div class="commento">
                    <div class="intestazione">
                        <p><?= $commento['nickname']; ?> - <?= $commento['data']; ?></p>
                    </div>
                    <div class="corpo">
                        <p><?= $commento['commento']; ?></p>
                    </div>
                    <div class="risposta">
                        <form action="/home/info-progetto/invia-risposta?nomeProgetto=<?= urldecode($_GET['nomeProgetto'])?>" method="post">
                            <input type="hidden" name="idCommento" value="<?= $commento['id']; ?>">
                            <input type="hidden" name="emailCreatore" value="<?= $_SESSION['utente']['email']; ?>">
                            <textarea name="contenuto" placeholder="Scrivi la tua risposta" required></textarea>
                            <button type="submit">Invia messaggio</button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
