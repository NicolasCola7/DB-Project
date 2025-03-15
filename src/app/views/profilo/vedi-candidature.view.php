<!DOCTYPE html>
<html>
<head>
    <title> Candidature </title>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>

    .contenutoMain {
        flex-grow: 1;
        max-height: 100%;
        overflow-y: auto; 
        padding: 20px;
        margin: 10px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
    }

    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
    }

    #divCandidature {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .candidatura {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 500px; 
        height: 50px;
        padding: 15px;
        display: flex;
        gap:15px;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .candidatura:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .candidatura p {
        margin: 0;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        color: black;
    }

    .candidatura span {
        font-weight: bold;
    }

    .candidatura button {
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
        background-color: #0077cc;
    }

    #filtroCandidature {
        width: 130px;
        height: 30px;
        font-size: 14px;
        border-radius: 4px;
    }

    .accettata {
        background-color: #00CB44;
        color: white;
    }

    .rifiutata > p {
        color: white;
    }

    .accettata > p {
        color: white;
    }

    .accettata > button {
        background-color: #008037;
    }

    .rifiutata{
        background-color: #FF4A4A;
    }

    .rifiutata  > button{
        background-color: #b00000;
    }
</style>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Candidature</h3>
            <p> Profilo: <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]); ?> </p>
            <p> Progetto: <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </p>
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
                            <p> Candidato:  <span> <?= $candidatura['nickname']; ?> </span></p>
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
    <?php if (isset($_SESSION["utente"]['errore_validazione'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Posti esauriti!",
                    text: "<?php echo $_SESSION["utente"]['errore_validazione']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_validazione']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_validazione'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_validazione']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_validazione']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
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