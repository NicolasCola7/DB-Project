<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
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

    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .divInfo {
        display: flex;
        flex-direction: column;
        gap:10px;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #555;
        border-radius: 10px;
        width: 50%;
        margin-bottom: 25px;
    }

    .divBottoni {
        display: flex;
        flex-direction: column;
        gap:10px;
        margin-top: 10px;
        width: 50%;
        margin-bottom: 25px;
    }

    form {
        width:100%;
        display: flex;
        gap:15px;
    }

    .container input {
        width: 400px;
        height:30px;
        font-size: 14px;
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

    .contenutoMain {
        margin: 20px;
    }

    .contenutoMain h3 {
        color: #333;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .divBottoni button {
        width: 140px;
        height: 50px;
        border-radius: 6px;
        border: none;
        color: white;
        font-size: medium;
    }

    #accetta {
        background-color: #008037;
    }

    #accetta:hover {
        background-color:rgb(0, 66, 29);
    }

    #rifiuta {
        background-color: red;
    }

    #rifiuta:hover {
        background-color:rgb(128, 0, 0);
    }
</style>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
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
        const emailCandidato = urlParam.get('email');
        getInfo();
        async function getInfo() {
            try {
                //eseguo una chiamata asincrona al controller passando due parametri
                const risposta = await axios.get("/home/info-progetto/profilo/check-candidatura-controller", {
                    params: { nomeProgetto: nomeProgetto, nomeProfilo: nomeProfilo , email: emailCandidato}
                });
                let dati = risposta.data;
                stampa(dati);
            } catch (error) {
                console.log(error);
            }
        }
        async function postDecisione(nome, cognome){
            stampaBottoni(nome, cognome);
        }
        function stampa(dati){
            let h3 = document.createElement("h3");
            h3.textContent = "Dettagli candidatura";
            main.appendChild(h3);
            
            const infoCandidato = dati[0][0];
            const skillPossedute = dati[1];
            const skillRichieste = dati[2];
            const skillExtra = dati[3];
            const noCandidatureGiaAperte = dati[4][0];
            const noIdoneita = dati[5][0];

            stampaDatiCandidato(infoCandidato);
            stampaSkillProfilo(skillPossedute,skillRichieste, noIdoneita);
            stampaSkillExtra(skillExtra);
            //permetto di accettare una candidatura solo se ancora non lo è stato fatto
            if(!noCandidatureGiaAperte.risultato){
                postDecisione(infoCandidato.nome, infoCandidato.cognome);
            }else{
                let p = document.createElement("p");
                p.textContent = "Questa candidatura è già stata esaminata.";
                main.appendChild(p);
            }
        }
        function stampaDatiCandidato(infoCandidato){
            let divInfo = document.createElement("div");
            divInfo.classList.add("divInfo");
            main.appendChild(divInfo);

            let h4 = document.createElement("h4");
            h4.textContent = "Candidato";
            divInfo.appendChild(h4);

            //metodo che mi stampa un dato del candidato
            function createInfoField(label, value) {
                let container = document.createElement("div");
                container.classList.add("container");

                let p = document.createElement("p");
                p.textContent = label;
                container.appendChild(p);

                let input = document.createElement("input");
                input.type = "text";
                input.value = value;
                input.disabled = true;
                container.appendChild(input);

                return container;
            }

            //stampo i dati del candidato
            divInfo.appendChild(createInfoField("Nome e cognome:", infoCandidato.nome + " " + infoCandidato.cognome));
            divInfo.appendChild(createInfoField("Email:", infoCandidato.email));
            divInfo.appendChild(createInfoField("Luogo di nascita:", infoCandidato.luogo_nascita));
            divInfo.appendChild(createInfoField("Anno di nascita:", infoCandidato.anno_nascita));
        }
        //metodo che stampa le skill
        function stampaSkillProfilo(skillPossedute,skillRichieste,noIdoneita){
            let skillDiv = document.createElement("div");
            skillDiv.classList.add("divInfo");
            main.appendChild(skillDiv);

            let h4 = document.createElement("h4");
            h4.textContent = "Skill richieste";
            skillDiv.appendChild(h4);
            
            //se l'utente non è più idoneo al profilo lo segnalo al creatore
            if(noIdoneita.isQualified === 'FALSE'){
                let p = document.createElement("p");
                p.textContent = "Il candidato a seguito dell'invio della candidatura ha modificato le sue skill diventando non idoneo al profilo";
                skillDiv.appendChild(p);
            }
            
            let table = document.createElement("table");
            let tr = document.createElement("tr");
            table.appendChild(tr);
            skillDiv.appendChild(table);

            let th1 = document.createElement("th");
            th1.textContent = "NOME";
            tr.appendChild(th1);

            let th2 = document.createElement("th");
            th2.textContent = "LIVELLO RICHIESTO";
            tr.appendChild(th2);

            let th3 = document.createElement("th");
            th3.textContent = "LIVELLO POSSEDUTO";
            tr.appendChild(th3);
            let i = 0;
            //scorro le skill richieste dal profilo possedute dal candidato
            skillPossedute.forEach(sk_p => {
                let tr = document.createElement("tr");
                table.appendChild(tr);

                let td1 = document.createElement("td");
                td1.textContent = sk_p.nomeSkill;

                //nella terza colonna stampo il livello minimo richiesto per quella skill dal profilo
                let td2 = document.createElement("td");
                td2.textContent = skillRichieste[i].livello;

                let td3 = document.createElement("td");
                td3.textContent = sk_p.livello;

                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                i = i + 1;
            });
        }
        //metodo che stampa ulteriori skill del candidato
        function stampaSkillExtra(skillExtra){
            let divSkill = document.createElement("div");
            divSkill.classList.add("divInfo");
            main.appendChild(divSkill);

            let h4 = document.createElement("h4");
            h4.textContent = "Ulteriori skill possedute dal candidato";
            divSkill.appendChild(h4);

            if(skillExtra.length !== 0){
                let table = document.createElement("table");
                let tr = document.createElement("tr");
                table.appendChild(tr);
                divSkill.appendChild(table);

                let th1 = document.createElement("th");
                th1.textContent = "NOME";
                tr.appendChild(th1);

                let th2 = document.createElement("th");
                th2.textContent = "LIVELLO";
                tr.appendChild(th2);
                skillExtra.forEach(sk_p => {
                    let tr = document.createElement("tr");
                    table.appendChild(tr);

                    let td1 = document.createElement("td");
                    td1.textContent = sk_p.nomeSkill;
                    let td2 = document.createElement("td");
                    td2.textContent = sk_p.livello;

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                });
            }else{
                //se non ci sono ulteriori skill informo l'utente
                let p = document.createElement("p");
                p.textContent = "Il candidato non possiede ulteriori skill al di fuori di quelle richieste dal profilo.";
                divSkill.appendChild(p);
            }
        }
        function stampaBottoni(nome, cognome){
            let divBottoni = document.createElement("div");
            divBottoni.classList.add("divBottoni");
            main.appendChild(divBottoni);

            //creo un form con un solo bottone che esegue una richiesta post e chiama un controller
            //che eseguirà la validazione della candidatura
            let form = document.createElement("form");
            form.method = "post";
            form.action = "/home/info-progetto/profilo/check-candidatura/esito";

            let btnAssunto = document.createElement("button");
            btnAssunto.type = "submit";
            btnAssunto.textContent = "Accetta";
            btnAssunto.id = "accetta";

            let btnRifiuta = document.createElement("button");
            btnRifiuta.type = "submit";
            btnRifiuta.textContent = "Rifiuta";
            btnRifiuta.id = "rifiuta";

            //campi da passare al controller
            let inputNomeProgetto = document.createElement("input");
            inputNomeProgetto.type = "hidden";
            inputNomeProgetto.name = "nomeProgetto";

            let inputNomeProfilo = document.createElement("input");
            inputNomeProfilo.type = "hidden";
            inputNomeProfilo.name = "nomeProfilo";

            let inputemailUtente = document.createElement("input");
            inputemailUtente.type = "hidden";
            inputemailUtente.name = "emailUtente";

            let inputSceltaCreatore = document.createElement("input");
            inputSceltaCreatore.type = "hidden";
            inputSceltaCreatore.name = "scelta";

            btnAssunto.addEventListener("click", function (event) {
                event.preventDefault(); 
                let encodedNomeProgetto = encodeURIComponent(nomeProgetto);
                let encodedNomeProfilo = encodeURIComponent(nomeProfilo);
                let encodedEmailUtente = encodeURIComponent(emailCandidato);
                inputNomeProgetto.value = nomeProgetto;
                inputNomeProfilo.value = nomeProfilo;
                inputemailUtente.value = emailCandidato;
                inputSceltaCreatore.value = 1;
                //chiedo conferma all'utente se desiderà veramente inoltrare la candidatura
                Swal.fire({
                    title: "Sei sicuro?",
                    text: "Vuoi davvero accettare la candidatura di "+nome +" "+cognome+" come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sì, procedi!",
                    cancelButtonText: "Annulla",
                    customClass: {
                        confirmButton: "my-confirm-button",
                        cancelButton: "my-cancel-button"
                    }
                }).then((result) => {
                    //se l'utente conferma faccio submit
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            })
            btnRifiuta.addEventListener("click", function (event) {
                event.preventDefault(); 
                let encodedNomeProgetto = encodeURIComponent(nomeProgetto);
                let encodedNomeProfilo = encodeURIComponent(nomeProfilo);
                let encodedEmailUtente = encodeURIComponent(emailCandidato);
                inputNomeProgetto.value = nomeProgetto;
                inputNomeProfilo.value = nomeProfilo;
                inputemailUtente.value = emailCandidato;
                inputSceltaCreatore.value = 0;
                //chiedo conferma all'utente se desiderà veramente inoltrare la candidatura
                Swal.fire({
                    title: "Sei sicuro?",
                    text: "Vuoi davvero rifiutare la candidatura di "+nome +" "+cognome+" come " + nomeProfilo + " per il progetto " + nomeProgetto + "?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sì, procedi!",
                    cancelButtonText: "Annulla",
                    customClass: {
                        confirmButton: "my-confirm-button",
                        cancelButton: "my-cancel-button"
                    }
                }).then((result) => {
                    //se l'utente conferma faccio submit
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            })
            form.appendChild(btnAssunto);
            form.appendChild(btnRifiuta);
            form.appendChild(inputNomeProgetto);
            form.appendChild(inputNomeProfilo);
            form.appendChild(inputemailUtente);
            form.appendChild(inputSceltaCreatore);
            divBottoni.appendChild(form);
        }
    });
</script>