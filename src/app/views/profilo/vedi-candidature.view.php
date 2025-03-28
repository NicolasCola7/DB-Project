<?php use \core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title> Bostarter </title>
    <link rel='stylesheet' type='text/css' href='/public/styles/profilo/vedi-candidature.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Candidature</h3>
            <p> 
                Profilo: 
                <span id='nomeProfilo'>
                    <?= htmlspecialchars(urldecode(explode('/', $_SERVER['REQUEST_URI'])[5])); ?>
                </span>
            </p>
            <p>
                Progetto:
                <span id='nomeProgetto'>
                    <?= htmlspecialchars(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3])); ?>
                </span>
            </p>
            <div>
                <label for="filtroCandidature">Filtra per stato:</label>
                <select id="filtroCandidature" name='filtroCandidature' onchange="filtraCandidature(this.value)">
                    <option value="tutte" <?= empty($_GET['filtro']) ? 'selected' : ''; ?>>
                        Tutte
                    </option>
                    <option value="accettata" <?= isset($_GET['filtro']) && $_GET['filtro'] === 'accettata' ? 'selected' : ''; ?>>
                        Accettata
                    </option>
                    <option value="rifiutata" <?= isset($_GET['filtro']) && $_GET['filtro'] === 'rifiutata' ? 'selected' : ''; ?>>
                        Rifiutata
                    </option>
                    <option value="aperta" <?= isset($_GET['filtro']) && $_GET['filtro'] === 'aperta' ? 'selected' : ''; ?>>
                        Aperta
                    </option>
                </select>
            </div>
            <div id='divCandidature'>
                <?php if(!empty($candidature)): ?>
                    <?php foreach($candidature as $candidatura): ?>
                        <div class='candidatura <?= ($candidatura['stato'] === 'chiusa' ? 
                             ($candidatura['risultato'] == 1 ? 'accettata' : 'rifiutata') : 
                             ''); ?>'>
                            <p> Candidato:  <span> <?= htmlspecialchars($candidatura['nickname']); ?> </span></p>
                            <button onclick="dettagliCandidatura(<?= urlencode($candidatura['id']); ?>)">
                                 Vedi dettagli
                            </button>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p> Nessuna candidatura per il filtro selezionato </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show() ?>
</body>

<script src='/public/js/profilo/vedi-candidature.script.js'></script>
</html>