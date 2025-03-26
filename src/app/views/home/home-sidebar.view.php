
<html>
    <head>
        <link rel='stylesheet' type='text/css' href='/public/styles/home/sidebar.style.css'>
    </head>

    <div class="sidebar">
        <ul>
            <li><a href="/home/progetti">Progetti disponibili</a></li>
            <?php if ($_SESSION['utente']['creatore']) : ?>
                <li><a href="/home/crea-progetto/informazioni-base">Crea un nuovo progetto</a></li> 
            <?php endif; ?>
            <?php if ($_SESSION['utente']['creatore']) : ?>
                <li><a href="/home/i-miei-progetti">I miei progetti</a></li>
            <?php endif; ?>
            <li><a href="/home/le-mie-skill">Le mie skill</a></li>
            <?php if ($_SESSION['utente']['admin']) : ?>
                <li><a href="/admin/home/gestione-skills">Gestione skills</a></li> 
            <?php endif; ?>
            <li><a href="/home/le-mie-candidature">Le mie candidature</a></li>
            <li><a href="/home/i-miei-finanziamenti">I miei finanziamenti</a></li>
            <li><a href="/home/statistiche">Visualizza statistiche</a></li>
        </ul>
    </div>
</html>