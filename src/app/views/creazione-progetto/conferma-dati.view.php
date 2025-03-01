<?php

//se l'utente non ha inserito le informazioni base lo redirigo alla pagina apposita
if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
    header('location: /home/crea-progetto/informazioni-base');
    exit();
}

//se l'utente, a seconda del tipo di progetto, non ha inserito rewards o profuli lo redirigo alle pagine apposite 
if(!$_SESSION['creazione-progetto']['step4']) {
    header('location: /home/crea-progetto/rewards');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insermento componenti</title>
    <style>

        .contenutoMain {
            margin: 20px 10%;
        }

        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            justify-content: center;
            color: #0077cc;
            border-bottom: 2px solid #0077cc;
            padding-bottom: 1em;
            margin-bottom: 1em;
            background: #fff;
        }

        

    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
                <h2> Conferma dati </h2>
            </header>

            <section>
                <div id='info-base'>
                    <table>
                        <thead>
                            <th> Nome </th>
                            <th> Data limite </th>
                            <th> Descrizione </th>
                            <th> Budget </th>
                            <th> Tipo </th>
                        </thead>

                        <tbody>
                            <tr>
                                <td id='nome-progetto'> <?= $_SESSIONE['creazione-progetto']['nome']; ?> </td>
                                <td id='data-limite'> <?= $_SESSIONE['creazione-progetto']['data-limite']; ?> </td>
                                <td id='descrizione'> <?= $_SESSIONE['creazione-progetto']['descrizione']; ?> </td>
                                <td id='budget'> <?= $_SESSIONE['creazione-progetto']['budget']; ?> </td>
                                <td id='tipo'> <?= $_SESSIONE['creazione-progetto']['tipo']; ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id='<?= ($_SESSIONE['creazione-progetto']['tipo']=== 'software' ? 'profili' : 'componenti'); ?>'>
                    <? if($_SESSIONE['creazione-progetto']['tipo']=== 'hardware') :?>
                        <table id='tabella-componenti'>
                            <thead>
                                <th> Nome componente </th>
                                <th> Descrizione </th>
                                <th> Quantità </th>
                                <th> Prezzo </th>
                            </thead>

                            <tbody>
                                <? foreach($_SESSIONE['creazione-progetto']['componenti'] as $componente): ?>
                                    <tr>
                                        <td class='nome-componente'> <?= $componente['nome']; ?> </td>
                                        <td class='descrizione-componente'> <?= $componente['descrizione']; ?> </td>
                                        <td class='quantità-componente'> <?= $componente['quantità']; ?> </td>
                                        <td class='prezzo-componente'> <?= $componente['prezzo']; ?> </td>
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                    <? else: ?>
                        <div>

                        </div>
                    <? endif; ?>
                </div>

                <div id='foto'>

                </div>

                <div id='rewards'>
                        
                </div>
            </section>

            
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
</body>

<script>
    function prosegui() {
        const rewards =  <?= count($_SESSION['creazione-progetto']['rewards']); ?>;
        if(rewards < 1) {
            alert("Devi inserire almeno una reward!");
        } else {
            window.location.href = '/home/crea-progetto/conferma-dati';
        }
    }
</script>
</html>