
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
            <li><a href="/home/statistiche">Visualizza statistiche</a></li>
        </ul>
    </div>
</html>