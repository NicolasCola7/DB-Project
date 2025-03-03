<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Creazione progetto</title>
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