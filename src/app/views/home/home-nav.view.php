<html>
    <head>
        <link rel='stylesheet' type='text/css' href='/public/styles/home/nav.style.css'>
    </head>

<header>
    <div>
        <h2>BOSTARTER</h2>
    </div>
    <div id='info'>
        <p>
            <?php
                $ruolo = $_SESSION['utente']['admin'] ? 'A' : ($_SESSION['utente']['creatore'] ? 'C' : 'N');
                echo " <span class='ruolo ruolo-$ruolo'>$ruolo</span>" . htmlspecialchars($_SESSION['utente']['nickname']) ;
            ?>
        </p>
        <form action='/logout' method='POST'>
            <input type="submit" value='Logout'>
        </form>
    </div>
</header>

</html>