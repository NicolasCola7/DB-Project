<?php
use core\AlertManager;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/crea-progetto.style.css'>
</head>
<body>

    <?php require view('/home/home-nav.view.php'); ?>

    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>

        <div class="contenutoMain">
            <h3>Crea un nuovo progetto</h3>

            <section>
                <form action="/home/crea-progetto/informazioni-base" method="POST">
                    
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
                    <button type="submit">Prosegui</button>
                </form>
            </section>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>
    <?= isset($errori) ? AlertManager::show($errori) : '' ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
