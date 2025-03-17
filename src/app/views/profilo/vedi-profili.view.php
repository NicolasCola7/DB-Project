<!DOCTYPE html>
<html>
<head>
    <title>Profili</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        #profili {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 20px;
        }

        .divProfilo {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 700px; 
            padding: 15px;
            display: flex;
            gap:15px;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .divProfilo:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .divProfilo p {
            margin: 0;
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
        }

        .divProfilo p:first-child {
            font-weight: bold;
            font-size: 16px;
            flex-grow: 1; 
        }

        .divProfilo p:last-child {
            font-size: 14px;
            color: #666;
        }

        .divProfilo button {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .divProfilo button:hover {
            background: #0056b3;
            color: white;
        }

        .aggiungi-profilo {
            background-color: #ffffff;
            border: 2px dashed #ddd;
            border-radius: 10px;
            width: 700px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .aggiungi-profilo:hover {
            background-color: #f9f9f9;
            border-color: #4CAF50;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .aggiungi-profilo .plus-icon {
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

        .aggiungi-profilo p {
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
            <h3>Profili disponibili - <span id='nomeProgetto'> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </span> </h3>
            <div id='profili'>
                <?php if(count($profili) > 0): ?>
                    <?php foreach($profili as $profilo): ?>
                        <div class='divProfilo'>
                            <p class='nome-profilo'> <?= $profilo['nome'] ?> </p>
                            <p> <?= $profilo['numero_posizioni'] ?> posizioni disponibili </p>
                            <button class='dettagli' onclick="vediDettagli('<?= urlencode($profilo['nome']) ?>')"> Vedi Dettagli </button>
                            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                                <button class='candidature' onclick="vediCandidature('<?= urlencode($profilo['nome']); ?>')">
                                     Visualizza Candidature
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p> Non sono disponibili profili per il seguente progetto </p>
                <?php endif; ?>
            </div>
    
            <!-- Pulsante per aggiungere un nuovo profilo -->
            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                <div class="aggiungi-profilo" onclick="aggiungiProfilo()">
                    <div class="plus-icon">+</div>
                    <p>Aggiungi Nuovo Profilo</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?php if (isset($_SESSION["utente"]['errore_candidatura'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Errore di inserimento!",
                    text: "<?php echo $_SESSION["utente"]['errore_candidatura']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_candidatura']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_candidatura'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_candidatura']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_candidatura']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
</body>

<script>
    const nomeProgetto = '<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>';
    
    function vediDettagli(nomeProfilo){
        window.location.href = `/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/${nomeProgetto}/profili/${nomeProfilo}/skills-richieste`;
    }

    function vediCandidature(nomeProfilo) {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature`;
    }
    
    function aggiungiProfilo() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-profilo`;
    }
</script>

</html>
