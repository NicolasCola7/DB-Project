<html>
    <header>
        <title> Bostarter | Admin-Home </title>
    </header>

    <body>
            <h1> Bentornato/a, <? echo($_SESSION['utente']['nickname']) ?> </h1>
            <form action='/logout' method='POST'>
                <input type="submit" value='Logout'>
            </form>
    </body>
</html>