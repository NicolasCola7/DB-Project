<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<style>
    html, body {
        height: 100vh; 
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden; 
    }    
        
    .main {
        display: flex;
        flex-grow: 1; 
        overflow: hidden; 
    }
        
    .contenutoMain {
        flex-grow: 1;
        max-height: 100%;
        overflow-y: auto; 
        padding: 20px;
        margin: 10px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        font-family: Arial, sans-serif;
    }

    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .contenutoMain p {
        font-size: 16px;
        color: #555;
        margin: 10px 0;
        display: flex;
        flex-direction: column;
    }

    .contenitoreSkill{
        display: flex;
        flex-direction: column;
        gap:20px;
    }

    .contenitoreSkill button{
        width: 140px;
        height: 50px;
        border-radius: 6px;
        background-color: #0077cc;
        border: none;
        color: white;
        font-size: medium;
    }

    .contenitoreSkill button:hover{
        background-color: #1a355f;
    }

    table {
        margin-top: 10px;
        margin-bottom: 20px;
        width: 70%;
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

    .swal2-popup .swal2-confirm {
        background-color: #0077cc;
        color: white;
    }

    .swal2-popup .swal2-cancel {
        background-color: red;
        color: white;
    }
</style>
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
                                <td> <?= $skill['nomeSkill']; ?> </td>
                                <td> <?= $skill['livello']; ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'progetti'): ?>
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