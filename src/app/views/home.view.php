<html>
    <header>
        <title> Home </title>
    </header>

    <body>
        <?php if (isset($_SESSION['utente']))  ?>
            <h1> Bentornato/a, <?php $_SESSION['utente']['email'] ?> </h1>
    </body>
</html>