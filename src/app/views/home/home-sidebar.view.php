
<html>
    <head>
        <style>
            /* Sidebar */
            .sidebar {
                width: 250px;
                background: #1e1e2d;
                color: white;
                padding: 20px;
                min-height: 100vh;
            }

            .sidebar ul {
                list-style: none;
            }

            .sidebar li {
                margin-bottom: 10px;
            }

            .sidebar a {
                color: #f8f9fa;
                text-decoration: none;
                display: block;
                padding: 10px;
                border-radius: 5px;
                transition: all 0.3s ease-in-out;
                font-weight: bold;
            }

            .sidebar a:hover {
                background: #0077cc;
                color: white;
                transform: scale(1.05);
            }
        </style>
    </head>

    <div class="sidebar">
        <ul>
            <li><a href="/home/visualizza-progetti-controller">Visualizza progetti disponibili</a></li>
            <li><a href="/home/le-mie-skill">Le mie skill</a></li>
            <?php if ($_SESSION['utente']['creatore']) : ?>
                <li><a href="/home/crea-progetto/informazioni-base">Crea un nuovo progetto</a></li> 
            <?php endif; ?>
            <?php if ($_SESSION['utente']['admin']) : ?>
                <li><a href="/admin/home/gestione-skills">Gestione skills</a></li> 
            <?php endif; ?>
            <?php if ($_SESSION['utente']['creatore']) : ?>
                <li><a href="">Inserisci le rewards</a></li> 
            <?php endif; ?>
            <?php if ($_SESSION['utente']['creatore']) : ?>
                <li><a href="">I miei progetti</a></li>
            <?php endif; ?>
            <li><a href="/home/visualizzaStatistiche">Visualizza statistiche</a></li>
            <?php if ($_SESSION['utente']['creatore']) : ?>
                <li><a href="">Inserisci profilo</a></li>
            <?php endif; ?>
        </ul>
    </div>
</html>