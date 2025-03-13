<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiche</title>
    <style>
        html, body {
            height: 100vh; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden; 
        }    
            
        .main {
            display: flex;
            flex-grow: 1; 
            overflow: hidden; 
        }

        .contenutoMain {
            flex-grow: 1;
            max-height: 100%;
            overflow-y: auto; 
            padding: 20px;
            margin: 10px;
        }

        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            background: white;
            color: #0077cc;
            justify-content: center;
            padding-bottom: 2%;
            border-bottom: 2px solid #0077cc;
        }

        .statistiche {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .statistica {
            display: grid;
            grid-template-columns: minmax(120px, 1fr) 1fr auto;
            gap: 15px;
            align-items: center;
            padding: 5%;
            border-bottom: 1px solid #0077cc;
            color: #0077cc;
        }

        .statistiche > h2 {
            text-align: center;
            color: #0077cc;
            margin-top: 20px;
        }

        table {
            margin-top: 10px;
            margin-bottom: 20px;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #aaa;
        }

        th, td {
            padding: 10px;
            border: 1px solid #aaa;
            text-align: left;
        }

        th {
            background-color: #0077cc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d8eaff;
        }


        .errore {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <?php require view('/home/home-nav.view.php'); ?>

    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>

        <div class="contenutoMain">
            <header>
                <h2>Statistiche</h2>
            </header>

            <div class="statistiche">
                <h2>Classifica Creatori per Affidabilità</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nickname</th>
                            <th>Affidabilità</th>
                        </tr>
                    </thead>
                    <tbody id="tabellaCreatori"></tbody>
                </table>
                <p id="erroreCreatori" class="errore"></p>

                <h2>Progetti Vicini al Completamento</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome Progetto</th>
                            <th>Budget Mancante (€)</th>
                            <th>Budget Avvio (€)</th>
                        </tr>
                    </thead>
                    <tbody id="tabellaProgetti"></tbody>
                </table>
                <p id="erroreProgetti" class="errore"></p>

                <h2>Classifica Finanziatori</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nickname</th>
                            <th>Totale Finanziamenti (€)</th>
                        </tr>
                    </thead>
                    <tbody id="tabellaFinanziatori"></tbody>
                </table>
                <p id="erroreFinanziatori" class="errore"></p>
            </div>
        </div>
    </div>

    <?php require view('/home/home-footer.view.php'); ?>
</body>
<!-- client java script -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        getStatistiche();

        async function getStatistiche() {
            try {
                const response = await axios.get("/ottieni-statistiche");
                console.log("Dati ricevuti:", response.data);
                const dati = response.data;
                stampaStatistiche(dati);
            } catch (error) {
                console.error("Errore nel recupero delle statistiche:", error);
            }
        }

        function stampaStatistiche(dati) {
            if (dati.classificaCreatori && dati.classificaCreatori.length > 0) {
                let tabellaCreatori = document.getElementById("tabellaCreatori");
                dati.classificaCreatori.forEach(creatore => {
                    let row = `<tr>
                        <td>${creatore.nickname}</td>
                        <td>${creatore.affidabilita}</td>
                    </tr>`;
                    tabellaCreatori.innerHTML += row;
                });
            } else {
                document.getElementById("erroreCreatori").textContent = "Nessun creatore disponibile.";
            }

            if (dati.progettiVicini && dati.progettiVicini.length > 0) {
                let tabellaProgetti = document.getElementById("tabellaProgetti");
                dati.progettiVicini.forEach(progetto => {
                    let row = `<tr>
                        <td>${progetto.nome}</td>
                        <td>${progetto.budget_mancante} €</td>
                        <td>${progetto.budget_avvio} €</td>
                    </tr>`;
                    tabellaProgetti.innerHTML += row;
                });
            } else {
                document.getElementById("erroreProgetti").textContent = "Nessun progetto vicino al completamento.";
            }

            if (dati.classificaFinanziatori && dati.classificaFinanziatori.length > 0) {
                let tabellaFinanziatori = document.getElementById("tabellaFinanziatori");
                dati.classificaFinanziatori.forEach(f => {
                    let row = `<tr>
                        <td>${f.nickname}</td>
                        <td>${f.totale_finanziamento} €</td>
                    </tr>`;
                    tabellaFinanziatori.innerHTML += row;
                });
            } else {
                document.getElementById("erroreFinanziatori").textContent = "Nessun finanziatore registrato.";
            }
        }
    });
</script>
</html>