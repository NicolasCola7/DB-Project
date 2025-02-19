<!DOCTYPE html>
<html>
    <head>
        <title> Home </title>
        <style>

        </style>
    </head>
    <body>
        <header>
            <div>
                <h2>BOSTARTER</h2>
            </div>
            <div>
                <img src="" alt="imgProfilo">
                <p><?php echo($_SESSION['utente']['nickname']) ?></p>
                <form action='/logout' method='POST'>
                    <input type="submit" value='Logout'>
                </form>
            </div>
        </header>
        <div class="main">
            <div class="sidebar">
                <div>
                    <ul>
                        <li><a href="">Visualizza progetti disponibili</a></li>
                        <li><a href="">Aggiorna le proprie skill</a></li>
                        <?php if ($_SESSION['checkCreatore']) : ?>
                            <li><a href="">Crea un nuovo progetto</a></li> 
                        <?php endif; ?>
                        <?php if ($_SESSION['checkAdmin']) : ?>
                            <li><a href="">Crea nuove skills</a></li> 
                        <?php endif; ?>
                        <?php if ($_SESSION['checkCreatore']) : ?>
                            <li><a href="">Inserisci le rewards</a></li> 
                        <?php endif; ?>
                        <?php if ($_SESSION['checkCreatore']) : ?>
                            <li><a href="">Visualizza i miei progetti</a></li>
                        <?php endif; ?>
                        <li><a href="">Visualizza statistiche</a></li>
                        <?php if ($_SESSION['checkCreatore']) : ?>
                            <li><a href="">Inserisci profilo</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="contenutoMain">

            </div>
        </div>
        <footer>
            <p>BOSTARTER - Copyright &copy;, 2025</p>
        </footer>
    </body>
</html>