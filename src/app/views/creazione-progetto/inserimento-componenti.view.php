<?php
// se non si sono inserite le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}
use core\AlertManager;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/inserimento-componenti.style.css'>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Inserimento componenti</h3>

            <section>
                <div>
                    <form id='form-componenti' action="/home/crea-progetto/hardware/componenti" method="POST">
                        <div class="container">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" placeholder="nome" required>
                        </div>
                        <div class="container">
                            <label for="descrizione">Descrizione</label>
                            <textarea id="descrizione" name="descrizione" rows="4" placeholder="descrizione" required></textarea>
                        </div>
                        <div class="container">
                            <label for="quantità">Quantità</label>
                            <input type="number" id="quantità" name="quantità" placeholder="quantità" min='1' required>
                         </div>
                        <div class="container">
                            <label for="prezzo">Prezzo</label>
                            <input type="number" id="prezzo" name="prezzo" placeholder="prezzo" min='1' required>
                        </div>
                        <div class='container-bottoni'>
                            <button id='aggiungi' type='submit'>Aggiungi componente</button>
                        </div>
                    </form>

                    <div id='container-tabella'>
                        <table>
                            <thead>
                                <tr>
                                    <th> Nome </th>
                                    <th> Descrizione </th>
                                    <th> Quantità </th>
                                    <th> Prezzo </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($_SESSION['creazione-progetto']['componenti']) > 0): ?>
                                    <?php foreach($_SESSION['creazione-progetto']['componenti'] as $componente): ?>
                                        <tr>
                                            <td> <?= htmlspecialchars($componente['nome']); ?> </td>
                                            <td> <?= htmlspecialchars($componente['descrizione']); ?> </td>
                                            <td> <?= htmlspecialchars($componente['quantità']); ?> </td>
                                            <td> <?= htmlspecialchars($componente['prezzo']); ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr> <td colspan='4'> Nessuna componente inserita  </td> </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class='container-bottoni2'>
                    <button id="btnProsegui" onclick='prosegui()'>Prosegui</button>
                </div>
            </section>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
<script>

    function prosegui() {
        let nComponenti = <?php echo count($_SESSION["creazione-progetto"]["componenti"]); ?>;
        if(nComponenti > 0) {
            <?php $_SESSION["creazione-progetto"]["step2"] = true; ?>
            window.location.href = "/home/crea-progetto/foto";
        } else {
            Swal.fire({
                title: "Attenzione!",
                text: "Devi inserire almeno una componente.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    } 
</script>
</html>