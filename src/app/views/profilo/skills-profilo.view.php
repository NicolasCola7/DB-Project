<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/profilo/skills-profilo.style.css'>
</head>

<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Skills richieste - <span id='nomeProfilo'> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]); ?> </span></h3>
            <div class='contenitoreSkill'>
                <p> Di seguito sono riportate le skill, e il loro rispettivo livello, richieste per candidarsi al profilo </p>
                <table>
                    <thead>
                        <tr>
                            <th> Nome </th>
                            <th> Livello Minimo </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($skills as $skill): ?> 
                            <tr>
                                <td> <?= htmlspecialchars($skill['nomeSkill']); ?> </td>
                                <td> <?= htmlspecialchars($skill['livello']); ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--l'utente creatore non può candidarsi a un profilo di un suo stesso progetto-->
                <?php if(($profiloEsistente[0]['numero_posizioni'] > 0) && (urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti') ): ?>
                    <form id='candidatiForm' action="/home/progetti/<?= (explode('/', $_SERVER['REQUEST_URI'])[3]) ?>/profili/<?= (explode('/', $_SERVER['REQUEST_URI'])[5]) ?>/candidature" method='POST'>
                        <button id='candidati' type='submit'> Invia candidatura </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let candidati = document.getElementById('candidati');
    let form = document.getElementById('candidatiForm');

    const nomeProgetto = '<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]) ?>';
    const nomeProfilo = '<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[5]) ?>';

    candidati.addEventListener('click', event => {
        event.preventDefault();

        Swal.fire({
            title: "Sei sicuro?",
            text: "Vuoi inviare la tua candidatura come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
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
                form.submit();
            }
        });
    });
</script>
</html>