<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<style>
    .contenutoMain {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
        padding: 20px;
        margin:20px;
    }
    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
    }

    .divCandidature{
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .candidatura {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 500px; 
        height: 50px;
        padding: 15px;
        display: flex;
        gap:15px;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .candidatura:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .candidatura p {
        margin: 0;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        color: white;
    }
    .candidatura span{
        font-weight: bold;
    }
    .candidatura button {
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }
    #filtroCandidature{
        width: 130px;
        height: 30px;
        font-size: 14px;
        border-radius: 4px;
    }
</style>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Candidature</h3>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?php if (isset($_SESSION["utente"]['errore_validazione'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Posti esauriti!",
                    text: "<?php echo $_SESSION["utente"]['errore_validazione']; ?>",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['errore_validazione']); // Elimina il messaggio di errore dopo averlo mostrato ?>
    <?php elseif (isset($_SESSION["utente"]['esito_validazione'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: "Successo!",
                    text: "<?php echo $_SESSION["utente"]['esito_validazione']; ?>",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        <?php unset($_SESSION["utente"]['esito_validazione']); // Elimina il messaggio di successo dopo averlo mostrato ?>
    <?php endif; ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const main = document.getElementsByClassName("contenutoMain")[0];
        const urlParam = new URLSearchParams(window.location.search);
        const nomeProgetto = urlParam.get('nomeProgetto');
        const nomeProfilo = urlParam.get('nomeProfilo');

        let candidature = [];
        getCandidature();

        async function getCandidature() {
            try {
                //eseguo una chiamata asincrona al controller passando due parametri
                const risposta = await axios.get("/home/info-progetto/profilo/candidature-controller", {
                    params: { nomeProgetto: nomeProgetto, nomeProfilo: nomeProfilo }
                });
                candidature = risposta.data;
                stampaCandidature(candidature);
            } catch (error) {
                console.log(error);
            }
        }

        function stampaCandidature(candidature) {
            main.innerHTML = "";
            let h3 = document.createElement("h3");
            h3.textContent = "Candidature";
            let p1 = document.createElement("p");
            p1.textContent = "Profilo: " + nomeProfilo;
            let p2 = document.createElement("p");
            p2.textContent = "Progetto: " + nomeProgetto;
            main.appendChild(h3);
            main.appendChild(p1);
            main.appendChild(p2);

            // Aggiungo il menu a tendina per il filtro
            let filtroDiv = document.createElement("div");
            filtroDiv.innerHTML = `
                <label for="filtroCandidature">Filtra per stato:</label>
                <select id="filtroCandidature">
                    <option value="tutte">Tutte</option>
                    <option value="accettata">Accettata</option>
                    <option value="rifiutata">Rifiutata</option>
                    <option value="aperta">Aperta</option>
                </select>
            `;
            main.appendChild(filtroDiv);

            // Evento per filtrare le candidature
            document.getElementById("filtroCandidature").addEventListener("change", function () {
                filtraCandidature(this.value);
            });

            renderizzaCandidature(candidature);
        }

        //Crea dinamicamente l'interfaccia per visualizzare le candidature, mostrando quelle filtrate
        function renderizzaCandidature(listaCandidature) {
            let divCandidature = document.createElement("div");
            divCandidature.classList.add("divCandidature");

            if (listaCandidature.length !== 0) {
                listaCandidature.forEach(c => {
                    let div = document.createElement("div");
                    div.classList.add("candidatura");

                    let p = document.createElement("p");
                    p.textContent = "Candidato: ";

                    let spanP = document.createElement("span");
                    spanP.textContent = c.nome + " " + c.cognome;
                    p.appendChild(spanP);

                    let button = document.createElement("button");
                    button.textContent = "Vedi dettagli";
                    //evento del bottone che rimanda al controller
                    button.addEventListener("click", function () {
                        let encodedNomeProgetto = encodeURIComponent(nomeProgetto);
                        let encodedNomeProfilo = encodeURIComponent(nomeProfilo);
                        let encodedEmail = encodeURIComponent(c.emailUtente)
                        window.location.href = `/home/info-progetto/profilo/check-candidatura?nomeProgetto=${encodedNomeProgetto}&nomeProfilo=${encodedNomeProfilo}&email=${encodedEmail}`;
                    });

                    // imposto lo stile del card della candidatura
                    if (c.stato === "chiusa" && c.risultato === 0) {
                        div.style.backgroundColor = "#FF4A4A"; 
                        button.style.backgroundColor = "#B00000";
                    } else if (c.stato === "chiusa" && c.risultato === 1) {
                        div.style.backgroundColor = "#00CB44";
                        button.style.backgroundColor = "#008037";
                    } else if (c.stato === "aperta" && c.risultato === 0) {
                        button.style.backgroundColor = "#0077cc";
                        p.style.color = "black";
                    }

                    div.appendChild(p);
                    div.appendChild(button);
                    divCandidature.appendChild(div);
                });
            } else {
                let p = document.createElement("p");
                p.textContent = "Nessuna candidatura corrisponde al filtro selezionato.";
                divCandidature.appendChild(p);
            }

            main.appendChild(divCandidature);
        }

        //Filtra l'elenco delle candidature in base allo stato selezionato dal menu a tendina e aggiorna la visualizzazione
        function filtraCandidature(filtro) {
            let candidatureFiltrate = candidature.filter(c => {
                if (filtro === "accettata") {
                    return c.stato === "chiusa" && c.risultato === 1;
                } else if (filtro === "rifiutata") {
                    return c.stato === "chiusa" && c.risultato === 0;
                } else if (filtro === "aperta") {
                    return c.stato === "aperta" && c.risultato === 0;
                } else {
                    return true;
                }
            });

            // Ricarico la lista delle candidature filtrate
            document.querySelector(".divCandidature")?.remove();
            renderizzaCandidature(candidatureFiltrate);
        }
    });
</script>
