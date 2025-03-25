<?php

// se ci si trova nella pagina di creazione del progetto
if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto') {
    // se non si sono inserite le informazioni base lo redirigo alla pagina apposita
    if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
        header('location: /home/crea-progetto/informazioni-base');
        exit();
    }
}
use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-componenti.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Inserimento componenti</h3>

            <section>
                <div>
                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto'): ?>
                        <form id='form-componenti' action="/home/crea-progetto/hardware/componenti" method="POST">
                    <?php else: ?>
                        <form id='form-componenti' action='/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>/componenti' method="POST">
                    <?php endif; ?>
                        <div class="container">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" placeholder="nome" required>
                        </div>
                        <div class="container">
                            <label for="descrizione">Descrizione</label>
                            <textarea id="descrizione" name="descrizione" rows="4" placeholder="descrizione" required></textarea>
                        </div>
                        <div class="container">
                            <label for="quantita">Quantita</label>
                            <input type="number" id="quantita" name="quantita" placeholder="quantita" min='1' required>
                         </div>
                        <div class="container">
                            <label for="prezzo">Prezzo (€)</label>
                            <input type="number" id="prezzo" name="prezzo" placeholder="prezzo" min='1' required>
                        </div>
                        <div class='container-bottoni'>
                            <button id='aggiungi' type='submit'>Aggiungi componente</button>
                        </div>
                    </form>
                    
                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto'): ?>
                        <div id='container-tabella'>
                            <table>
                                <thead>
                                    <tr>
                                        <th> Nome </th>
                                        <th> Descrizione </th>
                                        <th> Quantita </th>
                                        <th> Prezzo </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($_SESSION['creazione-progetto']['componenti']) > 0): ?>
                                        <?php foreach($_SESSION['creazione-progetto']['componenti'] as $componente): ?>
                                            <tr>
                                                <td> <?= htmlspecialchars($componente['nome']); ?> </td>
                                                <td> <?= htmlspecialchars($componente['descrizione']); ?> </td>
                                                <td> <?= htmlspecialchars($componente['quantita']); ?> </td>
                                                <td> <?= htmlspecialchars($componente['prezzo']); ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr> <td colspan='4'> Nessuna componente inserita  </td> </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'crea-progetto'): ?>
                    <div class='container-bottoni2'>
                        <button id="btnProsegui" onclick='prosegui()'>Prosegui</button>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>
</body>
<script>
    const form = document.getElementById('form-componenti');
    const prezzo = document.getElementById('prezzo');
    const quantita = document.getElementById('quantita');
    const aggiungiBtn = document.getElementById('aggiungi');
    const componenti = document.querySelectorAll('tbody > tr');

    aggiungiBtn.addEventListener('click', event => {
        event.preventDefault();

        if(normalizza(prezzo.value) > 999999999.99 ) {
            AlertManager.error('Il prezzo deve essere <= 999.999.999,99!');
            return;
        } 

        if(quantita.value > 999999999 ) {
            AlertManager.error('la quantità deve essere <= 999.999.999!');
            return;
        } 

        form.submit();
    })

    function prosegui() {
        let nComponenti = componenti.length;
        if(nComponenti > 0) {
            <?php $_SESSION["creazione-progetto"]["step2"] = true; ?>
            window.location.href = "/home/crea-progetto/foto";
        } else {
            AlertManager.error('Devi inserire almeno una componente.');
        }
    } 

    function normalizza(input) {
        let valore = parseFloat(input);
        let valoreStr = valore.toString();

        // Divido la parte intera e decimale
        const parts = valoreStr.split('.');

        // Se ci sono più di 2 cifree decimali le tronco
        if (parts.length > 1) {
            const interi = parts[0];
            const decimali = parts[1].slice(0, 2);

            // Ricostruusco il numero con massimo 2 cifre decimali
            return parseFloat(`${interi}.${decimali.padEnd(2, '0')}`);
        } else {
            // Se non ci sono decimali aggiungo ".00"
            return parseFloat(`${parts[0]}.00`);
        }
    }
</script>
</html>