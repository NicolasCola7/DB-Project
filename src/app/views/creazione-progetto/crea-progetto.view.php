<?php
use core\AlertManager;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/crea-progetto.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
</head>
<body>

    <?php require view('/home/home-nav.view.php'); ?>

    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>

        <div class="contenutoMain">
            <h3>Crea un nuovo progetto</h3>

            <section>
                <form action="/home/crea-progetto/informazioni-base" method="POST" id='prosegui-form'>
                    
                    <div class="container">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="nome" required>
                    </div>
                    
                    <div class="container">
                        <label for="data-limite">Data limite</label>
                        <input type="date" id="data-limite" name="data-limite" required>
                    </div>
                    
                    <div class="container">
                        <label for="descrizione">Descrizione</label>
                        <textarea id="descrizione" name="descrizione" rows="4" placeholder="descrizione" required></textarea>
                    </div>
                    
                    <div class="container">
                        <label for="budget">Budget (€)</label>
                        <input type="number" id="budget" name="budget" placeholder="budget" required>
                    </div>
                    
                    <div class="container radio-group">
                    <label>Tipologia</label>
                        <div class="radio">
                            <input type="radio" id="hardware" name="tipo" value="hardware" checked>
                            <label for="hardware">Hardware</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="software" name="tipo" value="software">
                            <label for="software">Software</label>
                        </div>
                    </div>
                    <button id='prosegui' type="submit">Prosegui</button>
                </form>
            </section>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show(); ?>
</body>

<script>
    const proseguiBtn = document.getElementById('prosegui');
    const form = document.getElementById('prosegui-form');
    const budget = document.getElementById('budget');

    proseguiBtn.addEventListener('click', event => {
        event.preventDefault();

        if(normalizza(budget.value) > 999999999.99) {
            AlertManager.error('Il budget deve essere <= 999.999.999,99!');
        } else {
            form.submit();
        }
    });


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
