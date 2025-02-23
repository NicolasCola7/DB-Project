

<div class="sidebar">
    <ul>
        <li><a href="/home/visualizza-progetti-controller">Visualizza progetti disponibili</a></li>
        <li><a href="/home/le-mie-skill">Le mie skill</a></li>
        <?php if ($_SESSION['utente']['creatore']) : ?>
            <li><a href="">Crea un nuovo progetto</a></li> 
        <?php endif; ?>
        <?php if ($_SESSION['utente']['admin']) : ?>
            <li><a href="/admin/home/gestione-skills">Gestione skills</a></li> 
        <?php endif; ?>
        <?php if ($_SESSION['utente']['creatore']) : ?>
            <li><a href="">Inserisci le rewards</a></li> 
        <?php endif; ?>
        <?php if ($_SESSION['utente']['creatore']) : ?>
            <li><a href="">Visualizza i miei progetti</a></li>
        <?php endif; ?>
        <li><a href="">Visualizza statistiche</a></li>
        <?php if ($_SESSION['utente']['creatore']) : ?>
            <li><a href="">Inserisci profilo</a></li>
        <?php endif; ?>
    </ul>
</div>