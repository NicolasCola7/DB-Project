<!DOCTYPE html>
<html>
<head>
    <title>Profili</title>
</head>
<style>
    .contenutoMain {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
        padding: 20px;
        margin:20px;
    }
    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .divProfilo {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 500px; 
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
        flex-grow: 1; /* Consente al nome di espandersi per occupare più spazio */
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


</style>

<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Profili disponibili - <span id='nomeProgetto'> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </span> </h3>
            <?php if(count($profili) > 0): ?>
                <?php foreach($profili as $profilo): ?>
                    <div class='divProfilo'>
                        <p class='nome-profilo'> <?= $profilo['nome'] ?> </p>
                        <p> <?= $profilo['numero_posizioni'] ?> posizioni disponibili </p>
                        <button class='dettagli' > Vedi Dettagli </button>
                        <button class='candidature' > Visualizza Candidature </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p> Non sono disponibili profili per il seguente progetto </p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>
    const nomeProgetto = document.getElementById('nomeProgetto').textContent;
    const profili = document.getElementsByClassName('divProfilo');
    
    for (var i = 0; i < profili.length; i++) {
        const nomeProfilo = document.getElementsByClassName('nome-profilo')[i].textContent;
        const dettagliBtn = document.getElementsByClassName('dettagli')[i];
        const candidatureBtn = document.getElementsByClassName('candidature')[i];

        dettagliBtn.addEventListener('click', event => {
            window.location.href =  `/home/i-miei-progetti/${encodeURIComponent(nomeProgetto)}/profili/${encodeURIComponent(nomeProfilo)}/skills-richieste`;
        });

        candidatureBtn.addEventListener('click', event => {
            window.location.href =`/home/i-miei-progetti/${encodeURIComponent(nomeProgetto)}/profili/${encodeURIComponent(nomeProfilo)}/candidature `;;
        });
    }
</script>

</html>
