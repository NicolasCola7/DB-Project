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
            <p> Profilo: <?= htmlspecialchars(urldecode(explode('/', $_SERVER['REQUEST_URI'])[5])); ?> </p>
            <p> Progetto: <?= htmlspecialchars(urldecode(explode('/', $_SERVER['REQUEST_URI'])[3])); ?> </p>
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

<script>
   const nomeProgetto = '<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>'
   const nomeProfilo = '<?= explode('/', $_SERVER['REQUEST_URI'])[5]; ?>'

    //Filtra l'elenco delle candidature in base allo stato selezionato dal menu a tendina e aggiorna la visualizzazione
    function filtraCandidature(filtro) {
        switch(filtro) {
            case "accettata":
                window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature?filtro=accettata`;
                break;
            case "rifiutata" :
                window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature?filtro=rifiutata`;
                break;
            case "aperta" :
                window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature?filtro=aperta`;
                break;
            case "tutte":
                window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature`;
                break;
            default:
                break;
        }
    }

    function dettagliCandidatura(id) {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/profili/${nomeProfilo}/candidature/${id}`;
    }

</script>
</html>