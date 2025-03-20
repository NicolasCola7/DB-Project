<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/successo-creazione.style.css'>
</head>
<body>

    <?php require view('/home/home-nav.view.php'); ?>

    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>

        <div class="contenutoMain">
            <header>
                <h2>Successo!</h2>
            </header>

            <section>
               <p> Progetto correttamente creato! Lo puoi trovere nella sezione "I miei progetti" </p>
            </section>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>

</body>
</html>