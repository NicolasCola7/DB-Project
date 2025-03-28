<?php use \core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/profilo/vedi-profili.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- recupero la sezione inn cui ci si trova -->
    <input type='hidden' id='sezione' value='<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>'>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>
                Profili disponibili -
                <span id='nomeProgetto'>
                     <?= htmlspecialchars(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3])); ?>
                </span>
             </h3>
            <div id='profili'>
                <?php if(count($profili) > 0): ?>
                    <?php foreach($profili as $profilo): ?>
                        <div class='divProfilo'>
                            <p class='nome-profilo'> <?= htmlspecialchars($profilo['nome']) ?> </p>
                            <p> <?= htmlspecialchars($profilo['numero_posizioni']) ?> posizioni disponibili </p>
                            <button class='dettagli' onclick="vediDettagli('<?= urlencode($profilo['nome']); ?>', '<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>')">
                                 Vedi Dettagli
                            </button>
                            <!--solo l'utente creatore di quel progetto può vedere il bottone che mostra le candidature-->
                            <?php if($_SESSION['utente']['creatore'] && htmlspecialchars(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2])) === 'i-miei-progetti'): ?>
                                <button class='candidature' onclick="vediCandidature('<?= urlencode($profilo['nome']); ?>', '<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>')">
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
              
                <div class="aggiungi-profilo" onclick="aggiungiProfilo('<?= explode('/', $_SERVER['REQUEST_URI'])[3] ?>')">
                    <div class="plus-icon">+</div>
                    <p>Aggiungi Nuovo Profilo</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show() ?>
</body>

<script src='/public/js/profilo/vedi-profili.script.js'></script>

</html>
