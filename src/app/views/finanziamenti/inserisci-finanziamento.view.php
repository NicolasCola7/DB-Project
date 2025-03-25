<?php use core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/finanziamenti/inserisci-finanziamento.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Finanzia il progetto <span> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </span></h3>

            <section>
                <form id='form-finanziamento' action='/home/progetti/<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?>/finanziamenti' method='POST'>
                    <div class='container'>
                        <label for="myProgress">Avanzamento finanziamenti attuale</label>
                        <div id="divFinanziamenti">
                            <progress id="myProgress" value="<?= htmlspecialchars(floatval($percFinanziamento)) ?>" max="100"></progress>
                            <div>
                                <span><?= htmlspecialchars(floatval($percFinanziamento)) ?>%</span>
                                <span><?= htmlspecialchars(floatval($valori['sommaRicevuta']))?> &euro; / <?= htmlspecialchars(floatval($valori['budget_avvio']))?> &euro;</span>
                            </div>
                        </div>
                    </div>
                
                    <div class='container'>
                        <label for='importo'>Importo (€)</label>
                        <input type='number' name='importo' id='importo' required min='1'>
                    </div>

                    <div class='container'>
                        <label for='tabella-rewards'> Seleziona una reward cliccando sulla riga corrispondente </label>
                        <table name="tabella-rewards">
                            <thead>
                                <tr>
                                    <th> Codice </th>
                                    <th> Descrizione </th>
                                    <th> Foto </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($rewards) > 0): ?>
                                    <?php foreach($rewards as $reward): ?>
                                        <tr class="reward" data-code="<?= htmlspecialchars($reward['codice']); ?>">
                                            <td class='codice-reward'> <?= htmlspecialchars($reward['codice']); ?> </td>
                                            <td class='descrizione-reward'> <?= htmlspecialchars($reward['descr']); ?> </td>
                                            <td class='immagine-reward'> 
                                                <img src='../../../../<?= htmlspecialchars($reward['urlFoto']); ?>' alt='immagine reward'>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan='3'>Non sono presenti rewards per questo progetto</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <input type="hidden" id="codice-reward" name="codice-reward" value="" required>
                    
                    <div class='container bottoni'>
                        <button type='submit' id="btnFinanzia">Invia Finanziamento</button>
                    </div>
                </form>
            </section>
            <?= AlertManager::show($errori ?? []) ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>

</body>


<script>
    const rewards = document.querySelectorAll('.reward');
    const codiceReward = document.getElementById('codice-reward');
    const form = document.getElementById('form-finanziamento');
    const btnFinanzia = document.getElementById('btnFinanzia');
    const sommaRicevuta = parseFloat(<?= json_encode($valori['sommaRicevuta']) ?>);
    const budgetAvvio = parseFloat(<?= json_encode($valori['budget_avvio']) ?>);

    rewards.forEach(reward => {
        reward.addEventListener('click', function() {
            // Elimino il valore del codice reward selezionata
            codiceReward.value= "";

            // Rimuovo la marcatura di reward selezionata da tutte le righe dell atabella
            rewards.forEach(r => r.classList.remove('reward-selezionata'));
            
            // Marco come selezionata la reward 
            this.classList.add('reward-selezionata');
            
            // Imposta il valore dell'input nascosto
            codiceReward.value = this.getAttribute('data-code');
        });
    });

    form.addEventListener('submit', event => {
        if(codiceReward.value === "") {
            event.preventDefault();
            AlertManager.error('Per finanziare il progetto devi selezionare una reward!');
        } 
    });

    btnFinanzia.addEventListener('click', event => {
        event.preventDefault();
        const importoValue = parseFloat(document.getElementById('importo').value);
        const sommaTotale = importoValue + sommaRicevuta;
        if (sommaTotale > budgetAvvio) {
            AlertManager.confirmAction({
                title: "Superamento budget",
                text: `Attenzione! Con questo finanziamento il progetto supererebbe il budget d'avvio (${budgetAvvio}€). Vuoi procedere comunque?`,
                onConfirm: () => form.submit()
            });
        } else {
            AlertManager.confirmAction({
                title: "Sei sicuro?",
                text: "Vuoi finanziare veramente questo progetto?",
                onConfirm: () => form.submit()
            });
        }
    });

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
    });
</script>
</html>