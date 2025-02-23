<html>
    <head>
        <style>
             /* Stile generale */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: Arial, sans-serif;
            }

            body {
                background-color: #f4f4f4;
                color: #333;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            /* Layout principale */
            .main {
                display: flex;
                flex: 1;
            }

            /* Contenuto principale */
            .contenutoMain {
                flex: 1;
                padding: 20px;
                background: white;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                margin: 20px;
            }
             header {
                background: #0077cc;
                color: white;
                padding: 15px 30px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            header h2 {
                margin: 0;
            }

            header div {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            header p {
                font-weight: bold;
                font-size: 16px;
            }


            header form input {
                background: #ff4d4d;
                color: white;
                border: none;
                padding: 7px 12px;
                cursor: pointer;
                border-radius: 5px;
                transition: background 0.3s;
                width: 100%;
            }

            header form input:hover {
                background: #cc0000;
            }
        </style>
    </head>

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

</html>

