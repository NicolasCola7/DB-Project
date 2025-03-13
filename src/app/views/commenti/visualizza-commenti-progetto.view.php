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
            background-color: #fafafa;
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
            gap: 20px;
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
            padding: 5px;
            border-radius: 10px;
            line-height: 1.5;
            margin-top: 15px;
            padding-left: 20px;
            background-color: #f1f8e9;
        }

        .risposta .commento {
            background: #e9ecef;
            box-shadow: none;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .risposta .intestazione {
            color: #333;
            font-size: 14px;
        }

        .risposta .corpo {
            color: #555;
            font-size: 15px;
        }

        /* Stile per il bottone Rispondi */
        .bottone {
            margin-top: 10px;
            text-align: right;
        }

        .bottone button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .bottone button:hover {
            background-color: #0056b3;
        }

        .bottone button:active {
            background-color: #004085; 
        }

        /* Rimuove il bordo di focus */
        .bottone button:focus {
            outline: none; 
        }

    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Commenti - <?= $nomeProgetto; ?></h3>
            <?php if(count($commenti) != 0): ?>
                <?php foreach ($commenti as $commento): ?>
                    <div class="commento">
                        <div class="intestazione">
                            <p><?= $commento['nickname']; ?> - <?= $commento['data']; ?></p>
                        </div>
                        <div class="corpo">
                            <p><?= $commento['commento']; ?></p>
                        </div>
                        <?php if($commento['risposta'] != null): ?>
                            <div class="risposta">
                                <p><?= $commento['risposta']; ?></p>
                            </div>
                            <?php elseif($_SESSION['utente']['creatore']): ?>
                            <div class="bottone">
                            <button type="submit" onclick="rispondi('<?= urlencode($commento['id']) ?>', '<?= $nomeProgetto ?>')">Rispondi</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Non sono presenti commenti per questo</p>
            <?php endif; ?>  
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?php if (isset($_SESSION["utente"]['errore_risposta'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Errore!",
                    text: "<?php echo $_SESSION["utente"]['errore_risposta']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_risposta']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_risposta'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_risposta']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_risposta']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script> 
    function rispondi(id, nomeProgetto){
        window.location.href =  `/home/info-progetto/rispondi-a-commento?nomeProgetto=${nomeProgetto}&idCommento=${id}`;
    }
</script>
</html>
