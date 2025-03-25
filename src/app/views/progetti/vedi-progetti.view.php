<?php 
use core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/progetti/vedi-progetti.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        
    </style>
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
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Cerca progetto per nome...">
                    <select id="statusFilter">
                        <option value="tutti">Stato: Tutti</option>
                        <option value="aperto">Aperto</option>
                        <option value="chiuso">Chiuso</option>
                    </select>
                    <select id="typeFilter">
                        <option value="tutti">Tipo: Tutti</option>
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                    </select>
                </div>

                <div class="grid">
                    <?php foreach ($progetti as $progetto): ?>
                        <?php if($progetto['nickname'] === $_SESSION['utente']['nickname']): ?>
                            <a href="/home/i-miei-progetti/<?= urlencode($progetto['NomeProgetto']) ?>">
                        <? else: ?>
                            <a href="/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']) ?>">
                        <?php endif; ?>
                            <div class="card" data-type="<?= htmlspecialchars($progetto['tipoProgetto']) ?>">
                                <div class="img">
                                    <img src="<?= '/'.htmlspecialchars($progetto['urlImmagine'])?>" alt="Foto del progetto" >
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
                                    <progress id="myProgress" value="<?= htmlspecialchars(floatval($progetto['avanzamento']) * 100) ?>" max="100"></progress>
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
                <p id="noProjectsMessage">
                    Nessun progetto trovato.
                </p>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltip = document.getElementById("tooltip-progress");
        const searchInput = document.getElementById("searchInput");
        const statusFilter = document.getElementById("statusFilter");
        const noProjectsMessage = document.getElementById("noProjectsMessage");

        document.querySelectorAll("progress").forEach(progress => {
            // Cambia colore della barra in base al valore
            let value = parseFloat(progress.value);

            // coloro di verde se la percentuale è minore del 70%, di arancione se è tra il 70% e il 100% e di rosso se è uguale al 100%
            if (value <= 70) 
            {
                progress.style.setProperty("--progress-color", "#4caf50");
            } 
            else if (value > 70 && value < 100) 
            {
                progress.style.setProperty("--progress-color", "#ff9800");
            } 
            else 
            {
                progress.style.setProperty("--progress-color", "#f44336");
            }

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

        //metodo richiamato ad ogni evento di input o change dei filtri
        function filterProjects() {
            const filter = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;
            const selectedType = typeFilter.value;
            const cards = document.querySelectorAll(".grid .card");
            let visibleCount = 0;

            cards.forEach(card => {
                //leggo il nome, lo stato e il tipo di ogni progetto
                const nomeProgetto = card.querySelector("#nomeProgetto p").textContent.toLowerCase();
                const statoProgetto = card.querySelector("#stato p").textContent.toLowerCase();
                const tipoProgetto = card.getAttribute("data-type").toLowerCase();

                //controllo se la stringa inserita nel filtro è inclusa nel filtro
                const matchesName = nomeProgetto.startsWith(filter);
                //controllo lo stato stato
                const matchesStatus = (selectedStatus === "tutti") || (statoProgetto === selectedStatus);
                const matchesType = (selectedType === "tutti") || (tipoProgetto === selectedType);

                if (matchesName && matchesStatus && matchesType) {
                    card.parentElement.style.display = "inline-block";
                    visibleCount++;
                } else {
                    card.parentElement.style.display = "none";
                }
            });

            //se non ci sono progetti visualizzati visualizzo il paragrafo
            noProjectsMessage.style.display = (visibleCount === 0) ? "block" : "none";
        }

        searchInput.addEventListener("input", filterProjects);
        statusFilter.addEventListener("change", filterProjects);
        typeFilter.addEventListener("change", filterProjects);
    });
</script>
</html>