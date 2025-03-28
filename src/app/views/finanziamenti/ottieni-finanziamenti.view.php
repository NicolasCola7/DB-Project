<?php 
    use core\AlertManager; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/finanziamenti/ottieni-finanziamenti.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>I miei finanziamenti</h3>
            <div class="filter-container">
                <label for="filtroProgetti">Filtra per progetto: </label>
                <select id="filtroProgetti">
                    <option value="tutti">Tutti</option>
                    <?php for($i = 0; $i < count($progettiFinanziati); $i++):?>
                        <option value="<?= htmlspecialchars($progettiFinanziati[$i]['nomeProgetto']) ?>"><?= htmlspecialchars($progettiFinanziati[$i]['nomeProgetto']) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div id="finanziamenti">
                <?php if (!empty($finanziamenti)): ?>
                    <?php foreach ($finanziamenti as $finanziamento): ?>
                    <div class="finanziamento" data-progetto="<?= htmlspecialchars($finanziamento['nomeProgetto']) ?>">
                        <div class="info">
                            <p><?= htmlspecialchars($finanziamento['data']) ?></p> - <p><?= htmlspecialchars($finanziamento['nomeProgetto']) ?></p>
                        </div>
                        <div class="divImg">
                            <div id="divFoto">
                                <strong>Progetto</strong>
                                <img src="/<?= htmlspecialchars(urldecode($finanziamento['logoProgetto'])); ?>">
                            </div>
                            <div id="divFoto">
                                <strong>Reward</strong>
                                <img src="/<?= htmlspecialchars(urldecode($finanziamento['fotoReward'])); ?>" 
                                    class="fotoReward" 
                                    data-descrizione="<?= htmlspecialchars($finanziamento['descrizioneReward']) ?>">
                            </div>
                        </div>
                        <div class="importo">
                            <strong>Importo</strong>
                            <p><?= htmlspecialchars($finanziamento['importo']) ?> &euro;</p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Non hai ancora effettuato nessun finanziamento</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?= AlertManager::show() ?>
    <?php require view('/home/home-footer.view.php'); ?>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltip = document.createElement("div");
        const filtroProgetti = document.getElementById("filtroProgetti");
        const finanziamenti = document.querySelectorAll(".finanziamento");

        tooltip.className = "tooltip-reward";
        document.body.appendChild(tooltip);

        const imgRewards = document.querySelectorAll(".fotoReward");

        imgRewards.forEach(img => {
            img.addEventListener("mouseenter", (event) => {
                tooltip.textContent = img.getAttribute("data-descrizione");
                tooltip.style.display = "block";
            });

            img.addEventListener("mousemove", (event) => {
                tooltip.style.top = (event.pageY + 10) + "px";
                tooltip.style.left = (event.pageX + 10) + "px";
            });

            img.addEventListener("mouseleave", () => {
                tooltip.style.display = "none";
            });
        });

        filtroProgetti.addEventListener("change", function () {
            const filtro = this.value;

            finanziamenti.forEach(finanziamento => {
                const nomeProgetto = finanziamento.getAttribute("data-progetto") || "";
                if (filtro === "tutti" || nomeProgetto === filtro) {
                    finanziamento.style.display = "flex";  // Usa "flex" se usi il flexbox, altrimenti "block"
                } else {
                    finanziamento.style.display = "none";
                }
            });
        });
    });
</script>