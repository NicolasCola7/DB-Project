<!DOCTYPE html>
<html>
<head>
    <title>Profili</title>
</head>
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
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 5%;
    }

    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    #profili {
        display: flex;
        flex-direction: column;
        gap: 5%;
    }

    .divProfilo {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 80%; 
        padding: 15px;
        display: flex;
        flex-direction: row;
        gap:15px;
        align-items: center;
        justify-content: space-around;
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

    #bottoni > button {
        background-color: #0077cc;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    #bottoni {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        gap: 5%;
    }

    /* Stile per il pulsante di aggiunta nuovo profilo */
    .aggiungi-profilo {
        background-color: #ffffff;
        border: 2px dashed #ddd;
        border-radius: 10px;
        width: 500px;
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
                            <div id='bottoni'>
                                <button class='dettagli' onclick="vediDettagli('<?= urlencode($profilo['nome']) ?>')"> Vedi Dettagli </button>
                                <button class='candidature' onclick="vediCandidature('<?= urlencode($profilo['nome']); ?>')"> Visualizza Candidature </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p> Non sono disponibili profili per il seguente progetto </p>
                <?php endif; ?>
            </div>
    
            <!-- Pulsante per aggiungere un nuovo profilo -->
            <div class="aggiungi-profilo" onclick="aggiungiProfilo()">
                <div class="plus-icon">+</div>
                <p>Aggiungi Nuovo Profilo</p>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>
    const nomeProgetto = '<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>';
    
    function vediDettagli(nomeProfilo){
        window.location.href =  `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/skills-richieste`;
    }

    function vediCandidature(nomeProfilo) {
        window.location.href =`/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature `;
    }
    
    function aggiungiProfilo() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-profilo`;
    }
</script>

</html>
