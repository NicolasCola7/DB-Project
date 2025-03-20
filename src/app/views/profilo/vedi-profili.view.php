<!DOCTYPE html>
<html>
<head>
    <title>Profili</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/profilo/vedi-profili.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Profili disponibili - <span id='nomeProgetto'> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </span> </h3>
            <div id='profili'>
                <?php if(count($profili) > 0): ?>
                    <?php foreach($profili as $profilo): ?>
                        <div class='divProfilo'>
                            <p class='nome-profilo'> <?= $profilo['nome'] ?> </p>
                            <p> <?= $profilo['numero_posizioni'] ?> posizioni disponibili </p>
                            <button class='dettagli' onclick="vediDettagli('<?= urlencode($profilo['nome']) ?>')">
                                 Vedi Dettagli
                            </button>
                            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                                <button class='candidature' onclick="vediCandidature('<?= urlencode($profilo['nome']); ?>')">
                                     Visualizza Candidature
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p> Non sono disponibili profili per il seguente progetto </p>
                <?php endif; ?>
            </div>
    
            <!-- Pulsante per aggiungere un nuovo profilo -->
            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                <div class="aggiungi-profilo" onclick="aggiungiProfilo()">
                    <div class="plus-icon">+</div>
                    <p>Aggiungi Nuovo Profilo</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?php if (isset($_SESSION["utente"]['errore_candidatura'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Errore di inserimento!",
                    text: "<?php echo $_SESSION["utente"]['errore_candidatura']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_candidatura']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_candidatura'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_candidatura']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_candidatura']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
</body>

<script>
    const nomeProgetto = '<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>';
    
    function vediDettagli(nomeProfilo){
        window.location.href = `/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/${nomeProgetto}/profili/${nomeProfilo}/skills-richieste`;
    }

    function vediCandidature(nomeProfilo) {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature`;
    }
    
    function aggiungiProfilo() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-profilo`;
    }
</script>

</html>
