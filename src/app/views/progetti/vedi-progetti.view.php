<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/progetti/vedi-progetti.style.css'>
</head>
<body>
<div id="tooltip-progress" class="tooltip-progress">Avanzamento finanziamenti</div>

    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <?php if(!empty($progetti) && is_array($progetti)): ?>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti'): ?>
                    <h3>Progetti disponibili</h3>
                <?php else: ?>
                    <h3>I miei progetti</h3>
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
                                    <progress id="myProgress" value="<?= floatval($progetto['avanzamento']) * 100?>" max="100"></progress>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltip = document.getElementById("tooltip-progress");

        document.querySelectorAll("progress").forEach(progress => {
            // Cambia colore della barra in base al valore
            let value = parseFloat(progress.value);

            if (value <= 70) 
            {
                progress.style.setProperty("--progress-color", "#4caf50"); // Verde
            } 
            else if (value > 70 && value < 100) 
            {
                progress.style.setProperty("--progress-color", "#ff9800"); // Arancione
            } 
            else 
            {
                progress.style.setProperty("--progress-color", "#f44336"); // Rosso
            }

            console.log(value);
            // Mostra il tooltip quando il mouse passa sopra
            progress.addEventListener("mouseenter", (event) => {
                tooltip.style.display = "block";
            });

            // Sposta il tooltip mentre il mouse si muove
            progress.addEventListener("mousemove", (event) => {
                tooltip.style.top = (event.pageY + 10) + "px"; 
                tooltip.style.left = (event.pageX + 10) + "px";
            });

            // Nasconde il tooltip quando il mouse esce
            progress.addEventListener("mouseleave", () => {
                tooltip.style.display = "none";
            });
        });
    });
</script>
</html>