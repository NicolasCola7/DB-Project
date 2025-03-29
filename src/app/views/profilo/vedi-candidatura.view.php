<? use \core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/profilo/vedi-candidatura.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/AlertManager.js"></script>
</head>

<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>
                <input type='hidden' id='nomeProgetto' value='<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?>'>
                <input type='hidden' id='nomeProfilo' value='<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]); ?>'>
                Dettagli candidatura 
                <span id='idCandidatura'>
                     <?=  urldecode(explode('/', $_SERVER['REQUEST_URI'])[7]); ?> 
                </span>
            </h3>
            <div class='divInfo'>
                <h4> Candidato </h4>
                <div class='container'>
                    <p> Nome e cognome: </p>
                    <input id='nome' type='text' disabled value="<?= htmlspecialchars($candidato[0]['nome']).' '.htmlspecialchars($candidato[0]['cognome']); ?>">
                </div>
                <div class='container'>
                    <p>Email:</p>
                    <input type='text' disabled value="<?= htmlspecialchars($candidato[0]['email']); ?>">
                </div>
                <div class='container'>
                    <p>Anno di nascita</p>
                    <input type='text' disabled value="<?= htmlspecialchars($candidato[0]['anno_nascita']); ?>">
                </div>
                <div class='container'>
                    <p>Luogo di nascita</p>
                    <input type='text' disabled value="<?= htmlspecialchars($candidato[0]['luogo_nascita']); ?>">
                </div>
            </div>
            <div class='divInfo'>
                <h4> Skills richieste</h4>
              
                <table>
                    <thead>
                        <tr>
                            <th> NOME </th>
                            <th> LIVELLO RICHIESTO </th>
                            <th> LIVELLO POSSEDUTO </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<count($richieste); $i++): ?>
                            <tr>
                                <td> <?= htmlspecialchars($richieste[$i]['nomeSkill']); ?> </td>
                                <td> <?= htmlspecialchars($richieste[$i]['livello']); ?> </td>
                                <td> <?= htmlspecialchars($possedute[$i]['livello']); ?> </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <?php if($idoneita[0]['isQualified'] === 'false'): ?>
                    <p> *** <b>Il candidato a seguito dell'invio della candidatura ha modificato le sue skill diventando non idoneo al profilo </b>***</p>
                <?php endif; ?>
            </div>
            <div class='divInfo'>
                <h4> Skills extra possedute dal candidato </h4>
                <?php if(!empty($posseduteExtra)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th> NOME </th>
                                <th> LIVELLO </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($posseduteExtra as $extra): ?>
                                <tr>
                                    <td> <?= htmlspecialchars($extra['nomeSkill']); ?> </td>
                                    <td> <?= htmlspecialchars($extra['livello']); ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p> Il candidato non possiede ulteriori skills </p>
                <?php endif; ?>       
            </div>
            <?php if(!$presente[0]['risultato']): ?>
                <div class='divBottoni'>
                    <form id='accettaForm' action="/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>/profili/<?= explode('/', $_SERVER['REQUEST_URI'])[5]; ?>/candidature/<?= explode('/', $_SERVER['REQUEST_URI'])[7]; ?>?scelta=accetta" method='POST'>
                        <input type='hidden' name='_metodo' value='PATCH'>
                        <button type='submit' id='accetta'> Accetta </button>
                    </form>
                    <form id='rifiutaForm' action="/home/i-miei-progetti/<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>/profili/<?= explode('/', $_SERVER['REQUEST_URI'])[5]; ?>/candidature/<?= explode('/', $_SERVER['REQUEST_URI'])[7]; ?>?scelta=rifiuta" method='POST'>
                        <input type='hidden' name='_metodo' value='PATCH'>
                        <button type='submit' id='rifiuta'> Rifiuta </button>
                    </form>
                </div>
            <?php else: ?>
                <p> Questa candidatura è già stata esaminata </p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show(); ?>
</body>

<script src='/public/js/profilo/gestione-candidatura.script.js'></script>

</html>
