<?php 
    use core\AlertManager; 
?>
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
                <form id='form-finanziamento' action='/home/progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>/finanziamenti' method='POST'>
                    <div class='container'>
                        <label for="myProgress">Avanzamento finanziamenti attuale</label>
                        <div id="divFinanziamenti">
                            <div>
                                <progress id="myProgress" value="<?= htmlspecialchars(number_format($valori['avanzamento'] * 100, 2)) ?>" max="100"></progress>
                                <span><?= htmlspecialchars(number_format($valori['avanzamento'] * 100, 2)) ?>%</span>
                            </div>
                            <div>
                                <span><?= htmlspecialchars(floatval($valori['sommaRicevuta']))?> &euro; / <?= htmlspecialchars(floatval($valori['budget_avvio']))?> &euro;</span>
                            </div>
                            <input type='hidden' id='ricevuti' value=<?= floatval($valori['sommaRicevuta'])?>>
                            <input type='hidden' id='budget' value=<?= floatval($valori['budget_avvio'])?>>
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
                                                <img src='/<?= htmlspecialchars($reward['urlFoto']); ?>' alt='immagine reward'>
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
            <?= AlertManager::show() ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>

</body>


<script src='/public/js/finanziamenti/inserisci-finanziamento.script.js'></script>
<script src='/public/js/normalizza.script.js'></script>

</html>