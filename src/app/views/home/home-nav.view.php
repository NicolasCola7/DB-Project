<header>
    <div>
        <h2>BOSTARTER</h2>
    </div>
    <div id='info'>
        <img src="/icona-profilo" alt='icona profilo'>
        <p><?php echo($_SESSION['utente']['nickname']) ?></p>
        <form action='/logout' method='POST'>
            <input type="submit" value='Logout'>
        </form>
    </div>
</header>