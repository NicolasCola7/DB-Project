<?php use core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/commenti/visualizza-commenti.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Commenti - <?= htmlspecialchars($nomeProgetto); ?></h3>
            <?php if(count($commenti) != 0): ?>
                <?php foreach ($commenti as $commento): ?>
                    <div class="commento">
                        <div class="intestazione">
                            <p><?= htmlspecialchars($commento['nickname']); ?> - <?= htmlspecialchars($commento['data']); ?></p>
                        </div>
                        <div class="corpo">
                            <p><?= htmlspecialchars($commento['commento']); ?></p>
                        </div>
                        <?php if($commento['risposta'] != null): ?>
                            <div class="risposta">
                                <p><?= htmlspecialchars($commento['risposta']); ?></p>
                            </div>
                        <?php elseif($_SESSION['utente']['email'] == $emailCreatore): ?>
                            <div class="bottone">
                                <button type="submit" onclick="rispondi('<?= urlencode(htmlspecialchars($commento['id'])) ?>', '<?= htmlspecialchars($nomeProgetto) ?>')">Rispondi</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Non sono presenti commenti per questo</p>
            <?php endif; ?>  
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show() ?>
</body>
<script src='/public/js/commenti/visualizza-commenti-progetto.script.js'> </script>
</html>
