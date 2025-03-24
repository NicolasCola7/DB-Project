<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/commenti/visualizza-commenti.style.css'>
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
    <?php if (isset($_SESSION["utente"]['errore_risposta'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Errore!",
                    text: "<?php echo $_SESSION["utente"]['errore_risposta']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_risposta']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_risposta'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_risposta']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_risposta']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script> 
    function rispondi(id, nomeProgetto){
        window.location.href =  `/home/i-miei-progetti/${nomeProgetto}/commenti/${id}/rispondi`;
    }
</script>
</html>
