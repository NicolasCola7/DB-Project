<?php 
use core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/progetti/vedi-progetti.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        
    </style>
</head>
<body>
<div id="tooltip-progress" class="tooltip-progress">Avanzamento finanziamenti</div>

    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti'): ?>
                <h3>Progetti disponibili</h3>
            <?php else: ?>
                <h3>I miei progetti</h3>
            <?php endif; ?>
                
            <?php if(!empty($progetti) && is_array($progetti)): ?>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Cerca progetto per nome...">
                    <select id="statusFilter">
                        <option value="tutti">Stato: Tutti</option>
                        <option value="aperto">Aperto</option>
                        <option value="chiuso">Chiuso</option>
                    </select>
                    <select id="typeFilter">
                        <option value="tutti">Tipo: Tutti</option>
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                    </select>
                </div>

                <div class="grid">
                    <?php foreach ($progetti as $progetto): ?>
                        <?php if($progetto['nickname'] === $_SESSION['utente']['nickname']): ?>
                            <a href="/home/i-miei-progetti/<?= urlencode($progetto['NomeProgetto']) ?>">
                        <? else: ?>
                            <a href="/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']) ?>">
                        <?php endif; ?>
                            <div class="card" data-type="<?= htmlspecialchars($progetto['tipoProgetto']) ?>">
                                <div class="img">
                                    <img src="<?= '/'.htmlspecialchars($progetto['urlImmagine'])?>" alt="Foto del progetto" >
                                </div>
                                <div class="info">
                                    <div id="nomeProgetto">
                                        <p><?= htmlspecialchars($progetto['NomeProgetto'])?>
                                    </div> 
                                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti'): ?>
                                        <div id='nomeUtente'>
                                            <p><?= htmlspecialchars($progetto['nickname'])?>
                                        </div>
                                    <?php endif; ?>
                                    <div id="stato" class="<?= $progetto['stato'] === 'aperto' ? 'stato-aperto' : 'stato-chiuso' ?>">
                                        <p><?= htmlspecialchars($progetto['stato']) ?></p>
                                    </div>  
                                </div>
                                <div class="progress">
                                    <progress id="myProgress" value="<?= htmlspecialchars(floatval($progetto['avanzamento']) * 100) ?>" max="100"></progress>
                                </div>
                                <div class="azioni">
                                    <?php  if($progetto['nickname'] !== $_SESSION['utente']['nickname']): ?>
                                        <form action='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']); ?>/commenta' method='GET'>
                                            <button type="submit">Commenta</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if($progetto['stato'] === 'aperto'): ?>
                                        <form action='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['NomeProgetto']); ?>/finanzia' method='GET'>  
                                        <button type="submit">Finanzia</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>   
            <?php else: ?>
                <p>Nessun progetto disponibile.</p>
            <?php endif; ?>
            <p id="noProjectsMessage">
                Nessun progetto trovato.
            </p>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show() ?>
</body>

<script src='/public/js/progetti/vedi-progetti.script.js'></script>
</html>