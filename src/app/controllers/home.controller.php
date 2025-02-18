<?

echo("Ciao {$_SESSION['utente']['nickname']}");

?>

<html>

    <body>
        <form action='/home/logout' method='POST'>
            <button type="submit"> Logout </button>
        </form>
    </body>

</html>