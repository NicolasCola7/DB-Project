<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<style>
    .contenutoMain {
        flex-grow: 1;
        max-height: 100%;
        overflow-y: auto; 
        padding: 20px;
        margin: 10px;
    }

    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .divInfo {
        display: flex;
        flex-direction: column;
        gap:10px;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #555;
        border-radius: 10px;
        width: 50%;
        margin-bottom: 25px;
    }

    .divBottoni {
        display: flex;
        flex-direction: row;
        gap:10px;
        margin-top: 10px;
        width: 50%;
        margin-bottom: 25px;
    }

    form {
        width:100%;
        display: flex;
    }

    .container input {
        width: 400px;
        height:30px;
        font-size: 14px;
    }

    table {
        margin-top: 10px;
        margin-bottom: 20px;
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #aaa;
    }

    th, td {
        padding: 10px;
        border: 1px solid #aaa;
        text-align: left;
    }

    th {
        background-color: #0077cc;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #d8eaff;
    }


    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .divBottoni button {
        width: 140px;
        height: 50px;
        border-radius: 6px;
        border: none;
        color: white;
        font-size: medium;
    }

    #accetta {
        background-color: #008037;
    }

    #accetta:hover {
        background-color:rgb(0, 66, 29);
    }

    #rifiuta {
        background-color: red;
    }

    #rifiuta:hover {
        background-color:rgb(128, 0, 0);
    }
</style>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>
                Dettagli candidatura 
                <span>
                     <?=  urldecode(explode('/', $_SERVER['REQUEST_URI'])[7]); ?> 
                </span>
            </h3>
            <div class='divInfo'>
                <h4> Candidato </h4>
                <div class='container'>
                    <p> Nome e cognome: </p>
                    <input id='nome' type='text' disabled value="<?= $candidato[0]['nome'].' '.$candidato[0]['cognome']; ?>">
                </div>
                <div class='container'>
                    <p>Email:</p>
                    <input type='text' disabled value="<?= $candidato[0]['email']; ?>">
                </div>
                <div class='container'>
                    <p>Anno di nascita</p>
                    <input type='text' disabled value="<?= $candidato[0]['anno_nascita']; ?>">
                </div>
                <div class='container'>
                    <p>Luogo di nascita</p>
                    <input type='text' disabled value="<?= $candidato[0]['luogo_nascita']; ?>">
                </div>
            </div>
            <div class='divInfo'>
                <h4> Skills richieste</h4>
                <?php if($idoneita[0]['isQualified']): ?>
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
                                    <td> <?= $richieste[$i]['nomeSkill']; ?> </td>
                                    <td> <?= $richieste[$i]['livello']; ?> </td>
                                    <td> <?= $possedute[$i]['livello']; ?> </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p> Il candidato a seguito dell'invio della candidatura ha modificato le sue skill diventando non idoneo al profilo </p>
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
                                    <td> <?= $extra['nomeSkill']; ?> </td>
                                    <td> <?= $extra['livello']; ?> </td>
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
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const nomeCandidato = document.getElementById('nome').value;
    const nomeProgetto = '<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) ?>';
    const nomeProfilo = '<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]) ?>';

    const rifiuta = document.getElementById('rifiutaForm');
    const accetta = document.getElementById('accettaForm');

    const rifiutaBtn = document.getElementById('rifiuta');
    const accettaBtn = document.getElementById('accetta');

    rifiutaBtn.addEventListener('click', event => {
        event.preventDefault();

        Swal.fire({
            title: "Sei sicuro?",
            text: "Vuoi davvero rifiutare la candidatura di " + nomeCandidato + " come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sì, procedi!",
            cancelButtonText: "Annulla",
            customClass: {
                confirmButton: "my-confirm-button",
                cancelButton: "my-cancel-button"
            }
         }).then((result) => {
            //se l'utente conferma faccio submit
            if (result.isConfirmed) {
                rifiuta.submit();
            }
        });
    });

    accettaBtn.addEventListener('click', event => {
        event.preventDefault();

        Swal.fire({
            title: "Sei sicuro?",
            text: "Vuoi davvero accettare la candidatura di " + nomeCandidato + " come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sì, procedi!",
            cancelButtonText: "Annulla",
            customClass: {
                confirmButton: "my-confirm-button",
                cancelButton: "my-cancel-button"
            }
         }).then((result) => {
            //se l'utente conferma faccio submit
            if (result.isConfirmed) {
                accetta.submit();
            }
        });
    });
</script>
</html>
